<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlainteRequest;
use App\Models\Plainte;
use App\Models\Service;
use App\Services\ActivityLogger;
use App\Services\NotificationService;
use App\Support\PlainteStatut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlainteApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Plainte::with(['service', 'user', 'agent'])->latest();

        if ($user->isCitoyen()) {
            $query->where('id_user', $user->id);
        } elseif ($user->isAgent()) {
            $query->where('agent_id', $user->id);
        } elseif ($user->isResponsable()) {
            $service = Service::where('responsable_id', $user->id)->first();
            if ($service) {
                $query->where('id_service', $service->id);
            }
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        return response()->json($query->paginate(20));
    }

    public function store(PlainteRequest $request)
    {
        $data = $request->validated();
        $data['code_suivi'] = Plainte::generateCodeSuivi();
        $data['id_user'] = Auth::id();
        $data['statut'] = PlainteStatut::EN_ATTENTE;

        if ($request->hasFile('piece_jointe')) {
            $data['piece_jointe'] = $request->file('piece_jointe')->store('plaintes', 'public');
        }

        $plainte = Plainte::create($data);
        ActivityLogger::log('create', "API — Plainte {$plainte->code_suivi}");
        NotificationService::plainteCreated($plainte);

        return response()->json($plainte->load('service'), 201);
    }

    public function show(Request $request, Plainte $plainte)
    {
        $this->authorizePlainte($request, $plainte);

        return response()->json($plainte->load(['service', 'reponses.agent', 'interventions.agent']));
    }

    public function track(string $code)
    {
        $plainte = Plainte::with(['service', 'reponses.agent', 'interventions'])
            ->where('code_suivi', strtoupper($code))
            ->first();

        if (! $plainte) {
            return response()->json(['message' => 'Plainte introuvable.'], 404);
        }

        return response()->json($plainte);
    }

    private function authorizePlainte(Request $request, Plainte $plainte): void
    {
        $user = $request->user();

        $allowed = $user->isAdmin()
            || $user->isResponsable()
            || ($user->isAgent() && $plainte->agent_id === $user->id)
            || ($user->isCitoyen() && $plainte->id_user === $user->id);

        if (! $allowed) {
            abort(403, 'Accès refusé.');
        }
    }
}
