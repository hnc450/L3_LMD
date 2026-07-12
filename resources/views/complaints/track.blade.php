@extends('base.base')

@section('title', 'Suivi de plainte')

@section('content')
@php use App\Support\PlainteStatut; @endphp
<div class="min-h-[calc(100vh-200px)] py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800">Suivi en temps réel</h1>
            <p class="text-gray-600 mt-2">Consultez l'évolution de votre plainte avec votre code de référence</p>
        </div>

        @include('layouts.alerts')

        <form method="POST" action="{{ route('public.track') }}" class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            @csrf
            <label class="block text-sm font-medium text-gray-700 mb-2">Code de référence</label>
            <div class="flex gap-3">
                <input type="text" name="code_suivi" value="{{ old('code_suivi', $plainte->code_suivi ?? request('code')) }}"
                       placeholder="PLT-XXXXXXXX" required class="flex-1 border rounded-xl px-4 py-3 uppercase font-mono">
                <button type="submit" class="bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-800">Rechercher</button>
            </div>
        </form>

        @isset($plainte)
        <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold">{{ $plainte->title }}</h2>
                    <p class="text-sm text-gray-500 font-mono">{{ $plainte->code_suivi }}</p>
                </div>
                @include('partials.statut-badge', ['statut' => $plainte->statut])
            </div>

            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-500">Service :</span> <strong>{{ $plainte->service?->name }}</strong></div>
                <div><span class="text-gray-500">Date :</span> <strong>{{ $plainte->created_at->format('d/m/Y H:i') }}</strong></div>
            </div>

            <div>
                <h3 class="font-semibold mb-3">Évolution du traitement</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-yellow-50 rounded-xl">
                        <span>🟡</span><span>Plainte déposée — {{ $plainte->created_at->format('d/m/Y') }}</span>
                    </div>
                    @if(in_array($plainte->statut, [PlainteStatut::EN_COURS, PlainteStatut::RESOLUE]))
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl">
                        <span>🔵</span><span>En cours de traitement</span>
                    </div>
                    @endif
                    @if($plainte->statut === PlainteStatut::RESOLUE)
                    <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl">
                        <span>🟢</span><span>Résolue — {{ $plainte->updated_at->format('d/m/Y') }}</span>
                    </div>
                    @endif
                    @if($plainte->statut === PlainteStatut::REJETEE)
                    <div class="flex items-center gap-3 p-3 bg-red-50 rounded-xl">
                        <span>🔴</span><span>Rejetée</span>
                    </div>
                    @endif
                </div>
            </div>

            @if(($interventions ?? $plainte->interventions)->count())
            <div>
                <h3 class="font-semibold mb-3">Interventions</h3>
                @foreach($interventions ?? $plainte->interventions as $intervention)
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-2">
                    <p class="text-sm font-medium">{{ $intervention->agent?->name ?? 'Agent' }} — {{ ucfirst($intervention->type) }}</p>
                    <p class="text-gray-700 mt-1">{{ $intervention->description }}</p>
                </div>
                @endforeach
            </div>
            @endif

            @if(($responses ?? $plainte->reponses)->count())
            <div>
                <h3 class="font-semibold mb-3">Réponses</h3>
                @foreach($responses ?? $plainte->reponses as $reponse)
                <div class="bg-green-50 border border-green-100 rounded-xl p-4 mb-2">
                    <p class="text-sm font-medium">{{ $reponse->agent?->name ?? 'Agent' }}</p>
                    <p class="text-gray-700 mt-1">{{ $reponse->message }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endisset
    </div>
</div>
@endsection
