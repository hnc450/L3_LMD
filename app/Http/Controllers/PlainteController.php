<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlainteRequest;
use App\Models\Plainte;
use App\Models\Service;
use App\Services\ActivityLogger;
use App\Services\NotificationService;
use App\Support\PlainteAccess;
use App\Support\PlainteStatut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlainteController extends Controller
{
    public function index(Request $request)
    {
        $query = Plainte::with(['service', 'user', 'agent'])->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('service')) {
            $query->where('id_service', $request->service);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('code_suivi', 'like', "%{$search}%");
            });
        }

        $plaintes = $query->paginate(15)->withQueryString();

        return view('admins.complaints.index', [
            'plaintes' => $plaintes,
            'complaints' => $plaintes,
            'statuts' => PlainteStatut::all(),
            'total' => Plainte::count(),
            'en_attente' => Plainte::where('statut', PlainteStatut::EN_ATTENTE)->count(),
            'en_cours' => Plainte::where('statut', PlainteStatut::EN_COURS)->count(),
            'resolues' => Plainte::where('statut', PlainteStatut::RESOLUE)->count(),
            'services' => Service::all(),
        ]);
    }

    public function create(Request $request)
    {
        $services = Service::all();

        if ($services->isEmpty()) {
            return redirect()->route('index')
                ->with('error', 'Aucun service disponible. Veuillez contacter l\'administration.');
        }

        return view('complaints.create', [
            'services' => $services,
            'serviceId' => $request->query('service'),
        ]);
    }

    public function store(PlainteRequest $request)
    {
        if (! Auth::check()) {
            return redirect()->route('auth.login')
                ->with('error', 'Vous devez être connecté pour soumettre une plainte.');
        }

        $services = Service::all();
        if ($services->isEmpty()) {
            return redirect()->route('index')
                ->with('error', 'Aucun service disponible. Veuillez contacter l\'administration.');
        }

        $data = $request->validated();
        $data['code_suivi'] = Plainte::generateCodeSuivi();
        $data['id_user'] = Auth::id();
        $data['statut'] = PlainteStatut::EN_ATTENTE;

        if (! Auth::check()) {
            $data['contact_nom'] = $data['nom'] ?? null;
            $data['contact_info'] = $data['contact'] ?? null;
        }

        unset($data['nom'], $data['contact']);

        if ($request->hasFile('piece_jointe')) {
            $data['piece_jointe'] = $request->file('piece_jointe')->store('plaintes', 'public');
        }

        $plainte = Plainte::create($data);

        ActivityLogger::log('create', "Plainte créée : {$plainte->code_suivi}", Auth::id());
        NotificationService::plainteCreated($plainte);

        if (Auth::check()) {
            return redirect()->route('user.dashboard')
                ->with('success', "Plainte enregistrée. Référence : {$plainte->code_suivi}");
        }

        return redirect()->route('public.track.form')
            ->with('success', "Plainte enregistrée. Référence : {$plainte->code_suivi}");
    }

    public function show(Plainte $plainte)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('public.track.form')
                ->with('info', 'Utilisez votre code de référence pour suivre votre plainte.');
        }

        abort_unless(PlainteAccess::canView($user, $plainte), 403);

        $plainte->load(['service', 'user', 'agent', 'reponses.agent', 'interventions.agent']);

        return view('complaints.show', [
            'plainte' => $plainte,
            'complaint' => $plainte,
            'responses' => $plainte->reponses,
            'interventions' => $plainte->interventions,
            'canEdit' => PlainteAccess::canEdit($user, $plainte),
        ]);
    }

    public function edit(Plainte $plainte)
    {
        abort_unless(PlainteAccess::canEdit(Auth::user(), $plainte), 403);

        return view('complaints.edit', [
            'plainte' => $plainte,
            'services' => Service::all(),
            'statuts' => PlainteStatut::all(),
        ]);
    }

    public function update(PlainteRequest $request, Plainte $plainte)
    {
        abort_unless(PlainteAccess::canEdit(Auth::user(), $plainte), 403);

        $data = $request->validated();
        $oldStatus = $plainte->statut;

        if ($request->hasFile('piece_jointe')) {
            if ($plainte->piece_jointe) {
                Storage::disk('public')->delete($plainte->piece_jointe);
            }
            $data['piece_jointe'] = $request->file('piece_jointe')->store('plaintes', 'public');
        }

        if (Auth::user()->isAdmin() || Auth::user()->isCitoyen()) {
            unset($data['statut']);
        }

        $plainte->update($data);

        if (isset($data['statut']) && $data['statut'] !== $oldStatus) {
            NotificationService::statusUpdated($plainte, $oldStatus);
            if ($plainte->statut === PlainteStatut::RESOLUE) {
                NotificationService::resolved($plainte);
            }
            ActivityLogger::log('update', "Statut {$plainte->code_suivi} : {$oldStatus} → {$plainte->statut}");
        }

        $redirect = Auth::user()->isResponsable()
            ? route('responsable.index')
            : (Auth::user()->isAdmin() ? route('admin.index') : route('user.dashboard'));

        return redirect($redirect)->with('success', 'Plainte mise à jour.');
    }

    public function destroy(Plainte $plainte)
    {
        abort_unless(Auth::user()->isResponsable() && PlainteAccess::canManage(Auth::user(), $plainte), 403);

        if ($plainte->piece_jointe) {
            Storage::disk('public')->delete($plainte->piece_jointe);
        }

        ActivityLogger::log('delete', "Plainte supprimée : {$plainte->code_suivi}");
        $plainte->delete();

        return redirect()->route('responsable.index')->with('success', 'Plainte supprimée.');
    }

    public function trackForm()
    {
        return view('complaints.track');
    }

    public function track(Request $request)
    {
        $request->validate(['code_suivi' => 'required|string']);

        $plainte = Plainte::with(['service', 'reponses.agent', 'interventions.agent'])
            ->where('code_suivi', strtoupper($request->code_suivi))
            ->first();

        if (! $plainte) {
            return back()->withErrors(['code_suivi' => 'Aucune plainte trouvée avec cette référence.']);
        }

        return view('complaints.track', [
            'plainte' => $plainte,
            'complaint' => $plainte,
            'responses' => $plainte->reponses,
            'interventions' => $plainte->interventions,
        ]);
    }
}
