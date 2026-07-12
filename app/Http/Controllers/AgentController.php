<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use App\Models\Reponse;
use App\Services\ActivityLogger;
use App\Services\InterventionService;
use App\Services\NotificationService;
use App\Support\PlainteStatut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $agentId = Auth::id();
        $agent = Auth::user();

        $query = Plainte::with(['service', 'user'])
            ->where('agent_id', $agentId)
            ->when($agent->id_service, fn ($q) => $q->where('id_service', $agent->id_service))
            ->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        $complaints = $query->paginate(15)->withQueryString();

        return view('agents.index', [
            'complaints' => $complaints,
            'actions' => Reponse::with('plainte')->where('agent_id', $agentId)->latest()->take(10)->get(),
            'statuts' => PlainteStatut::all(),
            'assignees' => Plainte::where('agent_id', $agentId)->count(),
            'en_cours' => Plainte::where('agent_id', $agentId)->where('statut', PlainteStatut::EN_COURS)->count(),
            'resolues' => Plainte::where('agent_id', $agentId)->where('statut', PlainteStatut::RESOLUE)->count(),
            'urgentes' => Plainte::where('agent_id', $agentId)->where('priorite', 'urgente')->count(),
        ]);
    }

    public function respond(Request $request)
    {
        $request->validate([
            'complaint_id' => 'required|exists:plaintes,id',
            'statut' => ['required', Rule::in([PlainteStatut::EN_COURS, PlainteStatut::RESOLUE, PlainteStatut::REJETEE])],
            'reponse' => 'required|string|min:10',
        ]);

        $plainte = Plainte::where('id', $request->complaint_id)
            ->where('agent_id', Auth::id())
            ->when(Auth::user()->id_service, fn ($q) => $q->where('id_service', Auth::user()->id_service))
            ->firstOrFail();

        $oldStatus = $plainte->statut;
        $plainte->update(['statut' => $request->statut]);

        Reponse::create([
            'agent_id' => Auth::id(),
            'complaint_id' => $plainte->id,
            'message' => $request->reponse,
        ]);

        InterventionService::create(
            $plainte,
            Auth::user(),
            'traitement',
            $request->reponse,
            $request->statut === PlainteStatut::RESOLUE ? 'terminee' : 'en_cours'
        );

        NotificationService::responseAdded($plainte, $request->reponse);

        if ($oldStatus !== $plainte->statut) {
            NotificationService::statusUpdated($plainte, $oldStatus);
            if ($plainte->statut === PlainteStatut::RESOLUE) {
                NotificationService::resolved($plainte);
            }
        }

        ActivityLogger::log('update', "Intervention agent sur {$plainte->code_suivi}");

        return back()->with('success', 'Réponse et intervention enregistrées.');
    }
}
