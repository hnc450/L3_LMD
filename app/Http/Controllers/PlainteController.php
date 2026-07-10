<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use App\Models\Service;
use App\Http\Requests\PlainteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlainteController extends Controller
{
    /**
     * Liste des plaintes
     */
    public function index()
    {
        $plaintes = Plainte::with('service','user')->latest()->paginate(10);
        return view('admins.complaints.index', compact('plaintes'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $services = Service::all();
        return view('complaints.create', compact('services'));
    }

    /**
     * Enregistrer une plainte
     */
    public function store(PlainteRequest $request)
    {
        $data = $request->validated();

        // Associer l’utilisateur connecté
        $data['id_user'] = Auth::id();

        // Gestion de la pièce jointe
        if ($request->hasFile('piece_jointe')) {
            $data['piece_jointe'] = $request->file('piece_jointe')->store('plaintes', 'public');
        }

        Plainte::create($data);

        return redirect()->route('complaints.index')->with('success', 'Plainte enregistrée avec succès');
    }

    /**
     * Afficher une plainte
     */
    public function show(string $id)
    {
        $plainte = Plainte::with('service','user')->findOrFail($id);
        return view('complaints.show', compact('plainte'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(string $id)
    {
        $plainte = Plainte::findOrFail($id);
        $services = Service::all();
        return view('complaints.edit', compact('plainte','services'));
    }

    /**
     * Mettre à jour une plainte
     */
    public function update(PlainteRequest $request, string $id)
    {
        $plainte = Plainte::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('piece_jointe')) {
            if ($plainte->piece_jointe) {
                Storage::disk('public')->delete($plainte->piece_jointe);
            }
            $data['piece_jointe'] = $request->file('piece_jointe')->store('plaintes', 'public');
        }

        $plainte->update($data);

        return redirect()->route('complaints.index')->with('success', 'Plainte mise à jour avec succès');
    }

    /**
     * Supprimer une plainte
     */
    public function destroy(string $id)
    {
        $plainte = Plainte::findOrFail($id);

        if ($plainte->piece_jointe) {
            Storage::disk('public')->delete($plainte->piece_jointe);
        }

        $plainte->delete();

        return redirect()->route('complaints.index')->with('success', 'Plainte supprimée avec succès');
    }
}
