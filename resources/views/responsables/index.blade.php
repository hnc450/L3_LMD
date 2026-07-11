@extends('base.responsable')

@section('title','Tableau de bord Responsable')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">Dashboard Responsable</h1>
            <p class="text-gray-500">Vue d'ensemble du service public.</p>
        </div>
        <a href="#" class="bg-indigo-600 text-white px-5 py-3 rounded-xl">Nouvelle intervention</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        @php
        $cards=[
        ['Plaintes','154','bg-red-500'],
        ['En attente','28','bg-yellow-500'],
        ['Interventions','96','bg-blue-500'],
        ['Agents actifs','18','bg-green-500'],
        ['Rapports','84','bg-purple-500'],
        ['Résolues','126','bg-emerald-500'],
        ['Urgentes','12','bg-orange-500'],
        ['Satisfaction','94%','bg-cyan-500']
        ];
        @endphp
        @foreach($cards as $card)
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="w-12 h-12 {{ $card[2] }} rounded-xl mb-4"></div>
            <h3 class="text-gray-500">{{ $card[0] }}</h3>
            <p class="text-3xl font-bold mt-2">{{ $card[1] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Dernières plaintes</h2>
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">#</th>
                        <th class="text-left">Sujet</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                @for($i=1;$i<=8;$i++)
                    <tr class="border-b">
                        <td class="py-3">PL-00{{ $i }}</td>
                        <td>Panne réseau secteur {{ $i }}</td>
                        <td><span class="px-2 py-1 bg-red-100 text-red-600 rounded">Urgente</span></td>
                        <td><span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">En cours</span></td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Rapports récents</h2>
            @for($i=1;$i<=6;$i++)
            <div class="border-b py-3">
                <p class="font-semibold">Agent {{ $i }}</p>
                <p class="text-gray-500 text-sm">Rapport intervention envoyé.</p>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection