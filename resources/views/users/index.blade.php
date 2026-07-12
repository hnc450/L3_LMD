@extends('base.user')

@section('title','Tableau de bord citoyen')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tableau de bord citoyen</h1>
            <p class="text-gray-500">Suivez vos plaintes et consultez vos notifications</p>
        </div>
        <a href="{{ route('complaints.create') }}" class="bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold hover:bg-blue-800">
            <i class="fa-solid fa-plus mr-2"></i>Nouvelle plainte
        </a>
    </div>

    <div class="grid md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-600">
            <p class="text-gray-500 text-sm">Total</p>
            <p class="text-3xl font-bold text-blue-700">{{ $plaintes->total() ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-yellow-500">
            <p class="text-gray-500 text-sm">🟡 En attente</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $en_attente ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm">🔵 En cours</p>
            <p class="text-3xl font-bold text-blue-600">{{ $en_cours ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-600">
            <p class="text-gray-500 text-sm">Résolues</p>
            <p class="text-3xl font-bold text-green-600">{{ $resolues ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b font-bold">Mes plaintes</div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Réf.</th>
                        <th class="px-4 py-3 text-left">Titre</th>
                        <th class="px-4 py-3 text-left">Service</th>
                        <th class="px-4 py-3 text-left">Statut</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($plaintes ?? [] as $complaint)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-blue-700">{{ $complaint->code_suivi ?? '#'.$complaint->id }}</td>
                        <td class="px-4 py-3">{{ $complaint->title }}</td>
                        <td class="px-4 py-3">{{ $complaint->service?->name }}</td>
                        <td class="px-4 py-3">@include('partials.statut-badge', ['statut' => $complaint->statut])</td>
                        <td class="px-4 py-3">{{ $complaint->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('complaints.show', $complaint) }}" class="bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-blue-800">
                                <i class="fa-solid fa-eye"></i> Voir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-4xl mb-3 block text-gray-300"></i>
                            Aucune plainte. <a href="{{ route('complaints.create') }}" class="text-blue-600 underline">Déposer une plainte</a>
                        </td>
                    </tr>
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
