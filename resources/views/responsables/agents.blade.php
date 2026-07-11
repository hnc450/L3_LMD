@extends('base.admin')

@section('title','Agents de mon service')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Agents affectés à mon service</h1>
            <p class="text-gray-500 mt-2">Consultez les agents, leur disponibilité et leurs performances.</p>
        </div>
        <a href="{{ route('responsable.agents.create') }}"
           class="mt-4 md:mt-0 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl">
            + Nouvel agent
        </a>
    </div>

    <div class="grid md:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl shadow p-5"><p class="text-gray-500">Agents</p><h2 class="text-3xl font-bold">{{  0 }}</h2></div>
        <div class="bg-white rounded-xl shadow p-5"><p class="text-gray-500">Disponibles</p><h2 class="text-3xl font-bold text-green-600">{{ 0 }}</h2></div>
        <div class="bg-white rounded-xl shadow p-5"><p class="text-gray-500">En mission</p><h2 class="text-3xl font-bold text-yellow-600">{{ 0 }}</h2></div>
        <div class="bg-white rounded-xl shadow p-5"><p class="text-gray-500">Indisponibles</p><h2 class="text-3xl font-bold text-red-600">{{ 0 }}</h2></div>
    </div>

    <div class="bg-white rounded-2xl shadow">
        <div class="p-6 border-b flex flex-col md:flex-row gap-3 justify-between">
            <input type="text" placeholder="Rechercher un agent..." class="border rounded-xl px-4 py-2 w-full md:w-80">
            <select class="border rounded-xl px-4 py-2">
                <option>Tous les statuts</option>
                <option>Disponible</option>
                <option>En mission</option>
                <option>Indisponible</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Agent</th>
                    <th class="px-6 py-3">Téléphone</th>
                    <th class="px-6 py-3">Fonction</th>
                    <th class="px-6 py-3">Statut</th>
                    <th class="px-6 py-3">Interventions</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($agents ?? [] as $agent)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-700">
                                {{ strtoupper(substr($agent->name,0,1)) }}
                            </div>
                            <div>
                                <p class="font-semibold">{{ $agent->name }}</p>
                                <p class="text-sm text-gray-500">{{ $agent->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $agent->phone }}</td>
                    <td class="px-6 py-4">{{ $agent->role ?? 'Agent' }}</td>
                    <td class="px-6 py-4">
                        @if($agent->status=='Disponible')
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">Disponible</span>
                        @elseif($agent->status=='En mission')
                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">En mission</span>
                        @else
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700">Indisponible</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $agent->interventions_count ?? 0 }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('responsable.agents.show',$agent->id) }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg">Voir</a>
                        <a href="{{ route('responsable.agents.edit',$agent->id) }}" class="px-3 py-2 bg-amber-500 text-white rounded-lg">Modifier</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-10 text-gray-500">Aucun agent affecté à ce service.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6">
            {{-- {{ $agents->links() }} --}}
        </div>
    </div>
</div>
@endsection
