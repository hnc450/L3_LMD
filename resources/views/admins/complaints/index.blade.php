@extends('base.admin')

@section('title','Administration des plaintes')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold">Administration des plaintes</h1>
        <p class="text-gray-500">Consultation en lecture seule — vous pouvez modifier uniquement vos propres plaintes</p>
    </div>

    <div class="grid md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow p-5"><p class="text-gray-500 text-sm">Total</p><p class="text-3xl font-bold">{{ $total ?? 0 }}</p></div>
        <div class="bg-white rounded-2xl shadow p-5"><p class="text-gray-500 text-sm">En attente</p><p class="text-3xl font-bold">{{ $en_attente ?? 0 }}</p></div>
        <div class="bg-white rounded-2xl shadow p-5"><p class="text-gray-500 text-sm">En cours</p><p class="text-3xl font-bold">{{ $en_cours ?? 0 }}</p></div>
        <div class="bg-white rounded-2xl shadow p-5"><p class="text-gray-500 text-sm">Résolues</p><p class="text-3xl font-bold">{{ $resolues ?? 0 }}</p></div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Réf.</th>
                        <th class="px-4 py-3 text-left">Citoyen</th>
                        <th class="px-4 py-3 text-left">Titre</th>
                        <th class="px-4 py-3 text-left">Service</th>
                        <th class="px-4 py-3 text-left">Statut</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($plaintes ?? $complaints ?? [] as $complaint)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-blue-700">{{ $complaint->code_suivi }}</td>
                        <td class="px-4 py-3">{{ $complaint->citoyenNom() }}</td>
                        <td class="px-4 py-3">{{ $complaint->title }}</td>
                        <td class="px-4 py-3">{{ $complaint->service?->name }}</td>
                        <td class="px-4 py-3">@include('partials.statut-badge', ['statut' => $complaint->statut])</td>
                        <td class="px-4 py-3">{{ $complaint->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('complaints.show', $complaint) }}" class="w-9 h-9 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center" title="Voir"><i class="fa-solid fa-eye"></i></a>
                                @if($complaint->id_user === auth()->id())
                                <a href="{{ route('complaints.edit', $complaint) }}" class="w-9 h-9 rounded-lg bg-yellow-100 text-yellow-700 flex items-center justify-center" title="Modifier"><i class="fa-solid fa-pen"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-12 text-center text-gray-500">Aucune plainte trouvée</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($plaintes) && $plaintes->hasPages())
        <div class="p-4 border-t">{{ $plaintes->links() }}</div>
        @endif
    </div>
</div>
@endsection
