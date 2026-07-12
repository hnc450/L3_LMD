<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use App\Models\Reponse;
use App\Models\Service;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\InterventionService;
use App\Services\NotificationService;
use App\Support\PlainteAccess;
use App\Support\PlainteStatut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ResponsableController extends Controller
{
    private function serviceOrAbort(): Service
    {
        $service = PlainteAccess::managedService(Auth::user());

        abort_unless($service, 403, 'Aucun service ne vous est assigné.');

        return $service;
    }

    public function index(Request $request)
    {
        $service = PlainteAccess::managedService(Auth::user());

        if (! $service) {
            return view('responsables.index', [
                'service' => null,
                'plaintes' => collect(),
                'agents' => collect(),
                'total' => 0,
                'en_attente' => 0,
                'en_cours' => 0,
                'resolues' => 0,
                'interventions' => 0,
            ]);
        }

        $query = Plainte::with(['user', 'agent'])
            ->where('id_service', $service->id)
            ->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('code_suivi', 'like', "%{$search}%");
            });
        }

        $plaintes = $query->paginate(15)->withQueryString();
        $plainteIds = Plainte::where('id_service', $service->id)->pluck('id');

        return view('responsables.index', [
            'service' => $service,
            'plaintes' => $plaintes,
            'agents' => $this->serviceAgents($service),
            'statuts' => PlainteStatut::all(),
            'total' => $plainteIds->count(),
            'en_attente' => Plainte::whereIn('id', $plainteIds)->where('statut', PlainteStatut::EN_ATTENTE)->count(),
            'en_cours' => Plainte::whereIn('id', $plainteIds)->where('statut', PlainteStatut::EN_COURS)->count(),
            'resolues' => Plainte::whereIn('id', $plainteIds)->where('statut', PlainteStatut::RESOLUE)->count(),
            'interventions' => \App\Models\Intervention::whereIn('plainte_id', $plainteIds)->count(),
        ]);
    }

    public function agents()
    {
        $service = $this->serviceOrAbort();
        $agents = $this->serviceAgents($service);

        $agentStats = $agents->map(function ($agent) use ($service) {
            $query = Plainte::where('agent_id', $agent->id)->where('id_service', $service->id);

            return (object) [
                'agent' => $agent,
                'assignees' => (clone $query)->count(),
                'resolues' => (clone $query)->where('statut', PlainteStatut::RESOLUE)->count(),
                'interventions' => \App\Models\Intervention::where('agent_id', $agent->id)->count(),
            ];
        });

        return view('responsables.agents', [
            'service' => $service,
            'agents' => $agentStats,
            'total_agents' => $agents->count(),
        ]);
    }

    public function createAgent()
    {
        $service = $this->serviceOrAbort();

        return view('responsables.agents-create', compact('service'));
    }

    public function storeAgent(Request $request)
    {
        $service = $this->serviceOrAbort();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|min:8|confirmed',
        ]);

        $agentRole = \App\Models\Role::where('name', 'agent')->firstOrFail();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'id_role' => $agentRole->id,
            'id_service' => $service->id,
            'created_by' => Auth::id(),
        ]);

        ActivityLogger::log('create', "Agent créé pour le service {$service->name} : {$request->email}");

        return redirect()->route('responsable.agents')
            ->with('success', 'Agent ajouté à votre service avec succès.');
    }

    public function assign(Request $request)
    {
        $service = $this->serviceOrAbort();

        $request->validate([
            'complaint_id' => 'required|exists:plaintes,id',
            'agent_id' => 'required|exists:users,id',
        ]);

        $plainte = Plainte::where('id', $request->complaint_id)
            ->where('id_service', $service->id)
            ->firstOrFail();

        $agent = User::where('id', $request->agent_id)
            ->where('id_service', $service->id)
            ->where('created_by', Auth::id())
            ->whereHas('role', fn ($q) => $q->where('name', 'agent'))
            ->firstOrFail();

        $oldStatus = $plainte->statut;
        $plainte->update([
            'agent_id' => $agent->id,
            'statut' => PlainteStatut::EN_COURS,
        ]);

        InterventionService::create(
            $plainte,
            $agent,
            'affectation',
            "Plainte affectée à l'agent {$agent->name} par le responsable."
        );

        ActivityLogger::log('assign', "Plainte {$plainte->code_suivi} → agent {$agent->name}");
        NotificationService::assigned($plainte, $agent);

        if ($oldStatus !== $plainte->statut) {
            NotificationService::statusUpdated($plainte, $oldStatus);
        }

        return back()->with('success', 'Plainte affectée à l\'agent.');
    }

    public function updateStatus(Request $request)
    {
        $service = $this->serviceOrAbort();

        $request->validate([
            'complaint_id' => 'required|exists:plaintes,id',
            'statut' => ['required', Rule::in(PlainteStatut::all())],
            'reponse' => 'nullable|string',
            'priorite' => 'nullable|in:normale,haute,urgente',
        ]);

        $plainte = Plainte::where('id', $request->complaint_id)
            ->where('id_service', $service->id)
            ->firstOrFail();

        $oldStatus = $plainte->statut;

        $plainte->update(array_filter([
            'statut' => $request->statut,
            'priorite' => $request->priorite,
        ]));

        if ($request->filled('reponse')) {
            Reponse::create([
                'agent_id' => $plainte->agent_id ?? Auth::id(),
                'complaint_id' => $plainte->id,
                'message' => $request->reponse,
            ]);
            NotificationService::responseAdded($plainte, $request->reponse);
        }

        if ($oldStatus !== $plainte->statut) {
            NotificationService::statusUpdated($plainte, $oldStatus);
            if ($plainte->statut === PlainteStatut::RESOLUE) {
                NotificationService::resolved($plainte);
            }
        }

        ActivityLogger::log('update', "Statut {$plainte->code_suivi} : {$request->statut}");

        return back()->with('success', 'Statut mis à jour.');
    }

    private function serviceAgents(Service $service)
    {
        return User::where('id_service', $service->id)
            ->where('created_by', Auth::id())
            ->whereHas('role', fn ($q) => $q->where('name', 'agent'))
            ->get();
    }
}
