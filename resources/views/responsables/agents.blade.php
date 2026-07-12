@extends('base.responsable')

@section('title','Agents du service')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <a href="{{ route('responsable.index') }}" class="text-indigo-600 text-sm hover:underline"><i class="fa-solid fa-arrow-left mr-1"></i> Retour</a>
            <h1 class="text-2xl font-bold mt-2">Mes agents — {{ $service?->name }}</h1>
            <p class="text-gray-500">{{ $total_agents ?? 0 }} agent(s) créé(s) par vous</p>
        </div>
        <a href="{{ route('responsable.agents.create') }}" class="bg-indigo-700 text-white px-5 py-3 rounded-xl font-medium hover:bg-indigo-800">
            <i class="fa-solid fa-user-plus mr-2"></i>Ajouter un agent
        </a>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($agents ?? [] as $item)
        <div class="bg-white rounded-2xl shadow-lg p-6 border-t-4 border-indigo-500">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr($item->agent->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold">{{ $item->agent->name }}</p>
                    <p class="text-sm text-gray-500">{{ $item->agent->email }}</p>
                    <p class="text-xs text-indigo-600">{{ $item->agent->phone ?? '—' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2 text-center text-sm">
                <div class="bg-slate-50 rounded-lg p-2">
                    <p class="font-bold text-indigo-700">{{ $item->assignees }}</p>
                    <p class="text-gray-500 text-xs">Assignées</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-2">
                    <p class="font-bold text-green-700">{{ $item->resolues }}</p>
                    <p class="text-gray-500 text-xs">Résolues</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-2">
                    <p class="font-bold text-purple-700">{{ $item->interventions }}</p>
                    <p class="text-gray-500 text-xs">Interventions</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl shadow p-12 text-center text-gray-500">
            <i class="fa-solid fa-users text-4xl text-gray-300 mb-3"></i>
            <p>Aucun agent créé. Ajoutez votre premier agent pour gérer les plaintes.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
