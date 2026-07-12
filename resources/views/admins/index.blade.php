@extends('base.admin')

@section('title', 'Tableau de bord administrateur')

@section('content')
@php use App\Support\PlainteStatut; @endphp
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tableau de bord administratif</h1>
        <p class="text-gray-500">Consultation globale des plaintes — modification uniquement de vos propres plaintes</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500"><i class="fa-solid fa-folder-open mr-1"></i> Total</p>
            <p class="text-3xl font-bold text-blue-700">{{ $total ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500"><i class="fa-solid fa-clock mr-1"></i> En attente</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $en_attente ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-indigo-500">
            <p class="text-sm text-gray-500"><i class="fa-solid fa-spinner mr-1"></i> En cours</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $en_cours ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500"><i class="fa-solid fa-circle-check mr-1"></i> Résolues</p>
            <p class="text-3xl font-bold text-green-600">{{ $resolues ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-5 border-b">
            <form method="GET" class="grid lg:grid-cols-6 gap-3">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
                       class="lg:col-span-2 border rounded-xl px-4 py-2 text-sm">
                <select name="statut" class="border rounded-xl px-3 py-2 text-sm">
                    <option value="">Tous statuts</option>
                    @foreach($statuts ?? PlainteStatut::all() as $s)
                        <option value="{{ $s }}" @selected(request('statut')===$s)>{{ $s }}</option>
                    @endforeach
                </select>
                <select name="service" class="border rounded-xl px-3 py-2 text-sm">
                    <option value="">Tous services</option>
                    @foreach($services ?? [] as $svc)
                        <option value="{{ $svc->id }}" @selected(request('service')==$svc->id)>{{ $svc->name }}</option>
                    @endforeach
                </select>
                <select name="priorite" class="border rounded-xl px-3 py-2 text-sm">
                    <option value="">Priorité</option>
                    @foreach(['normale','haute','urgente'] as $p)
                        <option value="{{ $p }}" @selected(request('priorite')===$p)>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
                <button class="bg-blue-700 text-white rounded-xl px-4 py-2 text-sm font-medium"><i class="fa-solid fa-filter mr-1"></i>Filtrer</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Réf.</th>
                        <th class="px-4 py-3 text-left">Titre</th>
                        <th class="px-4 py-3 text-left">Citoyen</th>
                        <th class="px-4 py-3 text-left">Service</th>
                        <th class="px-4 py-3 text-left">Priorité</th>
                        <th class="px-4 py-3 text-left">Statut</th>
                        <th class="px-4 py-3 text-left">Agent</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($complaints ?? [] as $complaint)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-blue-700">{{ $complaint->code_suivi }}</td>
                        <td class="px-4 py-3 font-medium">{{ $complaint->title }}</td>
                        <td class="px-4 py-3">{{ $complaint->citoyenNom() }}</td>
                        <td class="px-4 py-3">{{ $complaint->service?->name }}</td>
                        <td class="px-4 py-3">{{ ucfirst($complaint->priorite ?? 'normale') }}</td>
                        <td class="px-4 py-3">@include('partials.statut-badge', ['statut' => $complaint->statut])</td>
                        <td class="px-4 py-3">{{ $complaint->agent?->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('complaints.show', $complaint) }}" class="text-blue-600 hover:underline"><i class="fa-solid fa-eye mr-1"></i>Voir</a>
                                @if($complaint->id_user === auth()->id())
                                <a href="{{ route('complaints.edit', $complaint) }}" class="text-amber-600 hover:underline"><i class="fa-solid fa-pen mr-1"></i>Modifier</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="py-12 text-center text-gray-500">Aucune plainte</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($complaints) && $complaints->hasPages())
        <div class="p-4 border-t">{{ $complaints->links() }}</div>
        @endif
    </div>
</div>
@endsection
