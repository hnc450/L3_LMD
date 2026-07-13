@extends('base.responsable')

@section('title','Tableau de bord Responsable')

@section('content')
@php use App\Support\PlainteStatut; @endphp
<div class="space-y-6">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tableau de bord — Responsable</h1>
            <p class="text-gray-500">{{ $service?->name ?? 'Aucun service assigné' }}</p>
        </div>
        <div class="flex gap-3 flex-wrap">
            <a href="{{ route('responsable.agents.create') }}" class="bg-indigo-700 text-white px-5 py-3 rounded-xl font-medium hover:bg-indigo-800">
                <i class="fa-solid fa-user-plus mr-2"></i>Ajouter un agent
            </a>
            <a href="{{ route('responsable.agents') }}" class="border border-indigo-700 text-indigo-700 px-5 py-3 rounded-xl font-medium hover:bg-indigo-50">
                <i class="fa-solid fa-users mr-2"></i>Mes agents
            </a>
            <a href="{{ route('responsable.rapports') }}" class="border border-indigo-700 text-indigo-700 px-5 py-3 rounded-xl font-medium hover:bg-indigo-50">
                <i class="fa-solid fa-file-lines mr-2"></i>Rapports
            </a>
        </div>
    </div>

    @if($service)
    <div class="grid md:grid-cols-2 xl:grid-cols-5 gap-4">
        @foreach([
            ['label' => 'Plaintes', 'value' => $total ?? 0, 'icon' => 'fa-folder-open', 'color' => 'blue'],
            ['label' => 'En attente', 'value' => $en_attente ?? 0, 'icon' => 'fa-clock', 'color' => 'yellow'],
            ['label' => 'En cours', 'value' => $en_cours ?? 0, 'icon' => 'fa-spinner', 'color' => 'indigo'],
            ['label' => 'Résolues', 'value' => $resolues ?? 0, 'icon' => 'fa-circle-check', 'color' => 'green'],
            ['label' => 'Interventions', 'value' => $interventions ?? 0, 'icon' => 'fa-screwdriver-wrench', 'color' => 'purple'],
        ] as $card)
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-{{ $card['color'] }}-500">
            <p class="text-sm text-gray-500"><i class="fa-solid {{ $card['icon'] }} mr-1"></i>{{ $card['label'] }}</p>
            <p class="text-3xl font-bold mt-1">{{ $card['value'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-5 border-b flex flex-wrap justify-between items-center gap-4">
            <h2 class="font-bold">Plaintes du service</h2>
            <form method="GET" class="flex flex-wrap gap-2">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="border rounded-xl px-3 py-2 text-sm">
                <select name="statut" class="border rounded-xl px-3 py-2 text-sm">
                    <option value="">Tous statuts</option>
                    @foreach($statuts ?? PlainteStatut::all() as $s)
                    <option value="{{ $s }}" @selected(request('statut')===$s)>{{ $s }}</option>
                    @endforeach
                </select>
                <select name="priorite" class="border rounded-xl px-3 py-2 text-sm">
                    <option value="">Priorité</option>
                    @foreach(['normale','haute','urgente'] as $p)
                    <option value="{{ $p }}" @selected(request('priorite')===$p)>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
                <button class="bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm"><i class="fa-solid fa-filter"></i></button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Réf.</th>
                        <th class="px-4 py-3 text-left">Titre</th>
                        <th class="px-4 py-3 text-left">Citoyen</th>
                        <th class="px-4 py-3 text-left">Priorité</th>
                        <th class="px-4 py-3 text-left">Statut</th>
                        <th class="px-4 py-3 text-left">Agent</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($plaintes ?? [] as $plainte)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-indigo-700">{{ $plainte->code_suivi }}</td>
                        <td class="px-4 py-3">{{ $plainte->title }}</td>
                        <td class="px-4 py-3">{{ $plainte->citoyenNom() }}</td>
                        <td class="px-4 py-3">{{ ucfirst($plainte->priorite ?? 'normale') }}</td>
                        <td class="px-4 py-3">@include('partials.statut-badge', ['statut' => $plainte->statut])</td>
                        <td class="px-4 py-3">{{ $plainte->agent?->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2 flex-wrap">
                                <a href="{{ route('complaints.show', $plainte) }}" class="text-indigo-600 hover:underline"><i class="fa-solid fa-eye"></i></a>
                                <button type="button" onclick="openAssignModal({{ $plainte->id }})" class="text-green-600 hover:underline"><i class="fa-solid fa-user-plus"></i></button>
                                <button type="button" onclick="openStatusModal({{ $plainte->id }}, '{{ $plainte->statut }}', '{{ $plainte->priorite }}')" class="text-amber-600 hover:underline"><i class="fa-solid fa-arrows-rotate"></i></button>
                                <form method="POST" action="{{ route('complaints.destroy', $plainte) }}" onsubmit="return confirm('Supprimer cette plainte ?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-12 text-center text-gray-500">Aucune plainte pour ce service</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($plaintes) && method_exists($plaintes, 'hasPages') && $plaintes->hasPages())
        <div class="p-4 border-t">{{ $plaintes->links() }}</div>
        @endif
    </div>

    @include('partials.modals-responsable')
    @else
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center">
        <i class="fa-solid fa-triangle-exclamation text-3xl text-amber-600 mb-3"></i>
        <p class="text-amber-800 font-medium">Aucun service ne vous est assigné. Contactez l'administrateur.</p>
    </div>
    @endif
</div>
@endsection
