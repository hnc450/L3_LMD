<?php

namespace App\Http\Controllers;

use App\Models\Service;
Use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Afficher la liste des services
     */
    public function index()
    {
        $services = Service::latest()->paginate(10); // pagination
        return view('services.index', compact('services'));
    }

    
    /**
     * Formulaire de création
     */
    public function create()
    {
        $assignedIds = Service::whereNotNull('responsable_id')->pluck('responsable_id');

        $responsables = User::whereHas('role', fn ($q) => $q->where('name', 'responsable'))
            ->whereNotIn('id', $assignedIds)
            ->get();

        return view('services.create', compact('responsables'));
    }

    /**
     * Enregistrer un nouveau service
     */
    public function store(ServiceRequest $request)
    {
        $data = $request->validated();

        if ($error = $this->validateResponsable($data['responsable_id'] ?? null)) {
            return back()->withErrors(['responsable_id' => $error])->withInput();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service créé avec succès');
    }

    /**
     * Afficher un service spécifique
     */
    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        $assignedIds = Service::whereNotNull('responsable_id')
            ->where('id', '!=', $service->id)
            ->pluck('responsable_id');

        $responsables = User::whereHas('role', fn ($q) => $q->where('name', 'responsable'))
            ->where(function ($q) use ($assignedIds, $service) {
                $q->whereNotIn('id', $assignedIds)
                    ->orWhere('id', $service->responsable_id);
            })
            ->get();

        return view('services.edit', compact('service', 'responsables'));
    }

    /**
     * Mettre à jour un service
     */
    public function update(ServiceRequest $request, string $id)
    {
        $service = Service::findOrFail($id);
        $data = $request->validated();

        if ($error = $this->validateResponsable($data['responsable_id'] ?? null, $service->id)) {
            return back()->withErrors(['responsable_id' => $error])->withInput();
        }

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service mis à jour avec succès');
    }

    /**
     * Supprimer un service
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);

        // Supprimer l’image associée
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service supprimé avec succès');
    }

    private function validateResponsable(?int $responsableId, ?int $exceptServiceId = null): ?string
    {
        if (! $responsableId) {
            return null;
        }

        $exists = Service::where('responsable_id', $responsableId)
            ->when($exceptServiceId, fn ($q) => $q->where('id', '!=', $exceptServiceId))
            ->exists();

        return $exists ? 'Ce responsable gère déjà un autre service.' : null;
    }
}
