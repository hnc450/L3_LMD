@extends('base.user')

@section('title', 'Détail de la plainte')

@section('content')
@php 
    use App\Support\PlainteStatut; 
    $p = $plainte ?? $complaint ?? null; 
@endphp

<div class="max-w-6xl mx-auto px-4 py-6">

    <a href="{{ auth()->check() ? route(auth()->user()->dashboardRoute()) : route('public.track.form') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800 mb-6">
        <i class="fa-solid fa-arrow-left"></i>
        Retour
    </a>

    @if($p)

    <div class="grid lg:grid-cols-3 gap-6">

        <!-- CONTENU PRINCIPAL -->
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

                <div class="bg-gradient-to-r from-blue-900 via-blue-700 to-blue-500 p-6 text-white">
                    <div class="flex justify-between items-start gap-4">

                        <div>
                            <p class="text-blue-100 text-sm mb-2">Code de suivi</p>
                            <p class="font-mono font-bold text-lg">{{ $p->code_suivi }}</p>

                            <h1 class="text-3xl font-bold mt-4">
                                {{ $p->title }}
                            </h1>
                        </div>

                        @include('partials.statut-badge', ['statut' => $p->statut])

                    </div>
                </div>


                <div class="p-6">

                    <div class="grid md:grid-cols-2 gap-5 mb-8">

                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-gray-500 text-sm">Service concerné</p>
                            <p class="font-semibold mt-1">
                                {{ $p->service?->name ?? 'Non défini' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-gray-500 text-sm">Priorité</p>
                            <p class="font-semibold mt-1">
                                {{ ucfirst($p->priorite ?? 'normale') }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-gray-500 text-sm">Date de dépôt</p>
                            <p class="font-semibold mt-1">
                                {{ $p->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-gray-500 text-sm">Localisation</p>
                            <p class="font-semibold mt-1 break-words overflow-wrap-anywhere">
                                {{ $p->location ?? 'Non précisée' }}
                            </p>
                        </div>

                    </div>


                    <div>
                        <h2 class="font-bold text-xl mb-3">
                            Description
                        </h2>

                        <div class="bg-gray-50 rounded-2xl p-5 text-gray-700 leading-relaxed">
                            {{ $p->description }}
                        </div>
                    </div>


                    @if($p->piece_jointe)

                    <div class="mt-6">
                        <a href="{{ asset('storage/'.$p->piece_jointe) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-xl hover:bg-blue-700 transition">
                            <i class="fa-solid fa-paperclip"></i>
                            Voir la pièce jointe
                        </a>
                    </div>

                    @endif

                </div>

            </div>


            <!-- HISTORIQUE -->

            <div class="bg-white rounded-3xl shadow-xl p-6">

                <h2 class="text-xl font-bold mb-6">
                    Historique des traitements
                </h2>


                <div class="space-y-5">

                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                            📝
                        </div>

                        <div class="bg-yellow-50 rounded-2xl p-4 flex-1">
                            <p class="font-semibold">Plainte déposée</p>
                            <p class="text-sm text-gray-500">
                                {{ $p->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>


                    @foreach($interventions ?? $p->interventions ?? [] as $intervention)

                    <div class="flex gap-4">

                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            🔧
                        </div>

                        <div class="bg-blue-50 rounded-2xl p-4 flex-1">

                            <p class="font-semibold">
                                {{ ucfirst($intervention->type) }}
                                -
                                {{ $intervention->agent?->name ?? 'Agent' }}
                            </p>

                            <p class="text-gray-700 mt-2">
                                {{ $intervention->description }}
                            </p>

                            <p class="text-sm text-gray-500 mt-2">
                                {{ $intervention->created_at->format('d/m/Y H:i') }}
                            </p>

                        </div>

                    </div>

                    @endforeach


                    @foreach($responses ?? $p->reponses ?? [] as $reponse)

                    <div class="flex gap-4">

                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            💬
                        </div>

                        <div class="bg-green-50 rounded-2xl p-4 flex-1">

                            <p class="font-semibold">
                                {{ $reponse->agent?->name ?? 'Agent' }}
                            </p>

                            <p class="mt-2 text-gray-700">
                                {{ $reponse->message }}
                            </p>

                            <p class="text-sm text-gray-500 mt-2">
                                {{ $reponse->created_at->format('d/m/Y H:i') }}
                            </p>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>


        <!-- SIDEBAR -->

        <div class="space-y-6">

            <div class="bg-white rounded-3xl shadow-xl p-6">

                <h3 class="font-bold text-lg mb-5">
                    Suivi de la plainte
                </h3>


                <div class="space-y-4 text-sm">

                    <div class="flex gap-3 items-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                        Déposée
                    </div>


                    @if(in_array($p->statut,[PlainteStatut::EN_COURS,PlainteStatut::RESOLUE,PlainteStatut::REJETEE]))

                    <div class="flex gap-3 items-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                        En traitement
                    </div>

                    @endif


                    @if($p->statut === PlainteStatut::RESOLUE)

                    <div class="flex gap-3 items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        Résolue
                    </div>

                    @endif


                    @if($p->statut === PlainteStatut::REJETEE)

                    <div class="flex gap-3 items-center">
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        Rejetée
                    </div>

                    @endif

                </div>

            </div>


            <div class="bg-white rounded-3xl shadow-xl p-6">

                <h3 class="font-bold text-lg mb-4">
                    Actions
                </h3>


                @if($p->statut === PlainteStatut::RESOLUE && auth()->id() === $p->id_user)

                <a href="{{ route('feedback.create',$p) }}"
                   class="block text-center bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 mb-3">
                    Donner un feedback
                </a>

                @endif


                <a href="{{ route('public.track.form') }}"
                   class="block text-center border py-3 rounded-xl hover:bg-gray-50">
                    Suivi public
                </a>

            </div>

        </div>

    </div>

    @else

    <div class="bg-white rounded-3xl shadow p-12 text-center text-gray-500">
        Plainte non trouvée
    </div>

    @endif

</div>

@endsection