<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use App\Models\Reponse;
use App\Models\Rapport;
use App\Models\Service;
use App\Services\ActivityLogger;
use App\Services\InterventionService;
use App\Services\NotificationService;
use App\Support\PlainteStatut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    public function createRapport()
    {
        $agent = Auth::user();
        $service = Service::find($agent->id_service);

        if (!$service) {
            return back()->with('error', 'Aucun service assigné.');
        }

        $responsable = $service->responsable;

        return view('agents.rapport-create', compact('service', 'responsable'));
    }

    public function storeRapport(Request $request)
    {
        $agent = Auth::user();
        $service = Service::find($agent->id_service);

        if (!$service) {
            return back()->with('error', 'Aucun service assigné.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'file_attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        $data = [
            'agent_id' => $agent->id,
            'service_id' => $service->id,
            'responsable_id' => $service->responsable_id,
            'title' => $request->title,
            'content' => $request->content,
        ];

        if ($request->hasFile('file_attachment')) {
            $data['file_attachment'] = $request->file('file_attachment')->store('rapports', 'rapports');
        }

        Rapport::create($data);

        ActivityLogger::log('create', "Rapport soumis par l'agent {$agent->name}");

        return redirect()->route('agent.index')->with('success', 'Rapport soumis avec succès.');
    }
}
