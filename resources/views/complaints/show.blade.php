@extends('base.user')

@section('title', 'Détail de la plainte')

@section('content')
@php 
    use App\Support\PlainteStatut; 
    $p = $plainte ?? $complaint ?? null; 
@endphp

<div class="max-w-6xl mx-auto px-4 py-4 sm:py-6">

    <a href="{{ auth()->check() ? route(auth()->user()->dashboardRoute()) : route('public.track.form') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800 mb-4 sm:mb-6">
        <i class="fa-solid fa-arrow-left"></i>
        Retour
    </a>

    @if($p)

    <div class="grid lg:grid-cols-3 gap-4 sm:gap-6">

        <!-- CONTENU PRINCIPAL -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">

            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

                <div class="bg-gradient-to-r from-blue-900 via-blue-700 to-blue-500 p-4 sm:p-6 text-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">

                        <div>
                            <p class="text-blue-100 text-xs sm:text-sm mb-2">Code de suivi</p>
                            <p class="font-mono font-bold text-sm sm:text-lg">{{ $p->code_suivi }}</p>

                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mt-2 sm:mt-4">
                                {{ $p->title }}
                            </h1>
                        </div>

                        @include('partials.statut-badge', ['statut' => $p->statut])

                    </div>
                </div>


                <div class="p-4 sm:p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 mb-6 sm:mb-8">

                        <div class="bg-gray-50 rounded-xl sm:rounded-2xl p-3 sm:p-4">
                            <p class="text-gray-500 text-xs sm:text-sm">Service concerné</p>
                            <p class="font-semibold mt-1 text-sm sm:text-base">
                                {{ $p->service?->name ?? 'Non défini' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-xl sm:rounded-2xl p-3 sm:p-4">
                            <p class="text-gray-500 text-xs sm:text-sm">Priorité</p>
                            <p class="font-semibold mt-1 text-sm sm:text-base">
                                {{ ucfirst($p->priorite ?? 'normale') }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-xl sm:rounded-2xl p-3 sm:p-4">
                            <p class="text-gray-500 text-xs sm:text-sm">Date de dépôt</p>
                            <p class="font-semibold mt-1 text-sm sm:text-base">
                                {{ $p->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-xl sm:rounded-2xl p-3 sm:p-4">
                            <p class="text-gray-500 text-xs sm:text-sm">Localisation</p>
                            <p class="font-semibold mt-1 text-sm sm:text-base break-words overflow-wrap-anywhere">
                                {{ $p->location ?? 'Non précisée' }}
                            </p>
                        </div>

                    </div>


                    <div>
                        <h2 class="font-bold text-lg sm:text-xl mb-3">
                            Description
                        </h2>

                        <div class="bg-gray-50 rounded-xl sm:rounded-2xl p-4 sm:p-5 text-gray-700 leading-relaxed text-sm sm:text-base">
                            {{ $p->description }}
                        </div>
                    </div>


                    @if($p->piece_jointe)

                    <div class="mt-4 sm:mt-6">
                        <a href="{{ asset('storage/'.$p->piece_jointe) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 sm:px-5 sm:py-3 rounded-xl hover:bg-blue-700 transition text-sm sm:text-base">
                            <i class="fa-solid fa-paperclip"></i>
                            Voir la pièce jointe
                        </a>
                    </div>

                    @endif

                </div>

            </div>


            <!-- HISTORIQUE -->

            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-4 sm:p-6">

                <h2 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6">
                    Historique des traitements
                </h2>


                <div class="space-y-4 sm:space-y-5">

                    <div class="flex gap-3 sm:gap-4">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-yellow-100 flex items-center justify-center text-sm">
                            📝
                        </div>

                        <div class="bg-yellow-50 rounded-xl sm:rounded-2xl p-3 sm:p-4 flex-1">
                            <p class="font-semibold text-sm sm:text-base">Plainte déposée</p>
                            <p class="text-xs sm:text-sm text-gray-500">
                                {{ $p->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>


                    @foreach($interventions ?? $p->interventions ?? [] as $intervention)

                    <div class="flex gap-3 sm:gap-4">

                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-100 flex items-center justify-center text-sm">
                            🔧
                        </div>

                        <div class="bg-blue-50 rounded-xl sm:rounded-2xl p-3 sm:p-4 flex-1">

                            <p class="font-semibold text-sm sm:text-base">
                                {{ ucfirst($intervention->type) }}
                                -
                                {{ $intervention->agent?->name ?? 'Agent' }}
                            </p>

                            <p class="text-gray-700 mt-2 text-sm sm:text-base">
                                {{ $intervention->description }}
                            </p>

                            <p class="text-xs sm:text-sm text-gray-500 mt-2">
                                {{ $intervention->created_at->format('d/m/Y H:i') }}
                            </p>

                        </div>

                    </div>

                    @endforeach


                    @foreach($responses ?? $p->reponses ?? [] as $reponse)

                    <div class="flex gap-3 sm:gap-4">

                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-green-100 flex items-center justify-center text-sm">
                            💬
                        </div>

                        <div class="bg-green-50 rounded-xl sm:rounded-2xl p-3 sm:p-4 flex-1">

                            <p class="font-semibold text-sm sm:text-base">
                                {{ $reponse->agent?->name ?? 'Agent' }}
                            </p>

                            <p class="mt-2 text-gray-700 text-sm sm:text-base">
                                {{ $reponse->message }}
                            </p>

                            <p class="text-xs sm:text-sm text-gray-500 mt-2">
                                {{ $reponse->created_at->format('d/m/Y H:i') }}
                            </p>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>


        <!-- SIDEBAR -->

        <div class="space-y-4 sm:space-y-6">

            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-4 sm:p-6">

                <h3 class="font-bold text-base sm:text-lg mb-4 sm:mb-5">
                    Suivi de la plainte
                </h3>


                <div class="space-y-3 sm:space-y-4 text-xs sm:text-sm">

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


            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-4 sm:p-6">

                <h3 class="font-bold text-base sm:text-lg mb-3 sm:mb-4">
                    Actions
                </h3>


                @if($p->statut === PlainteStatut::RESOLUE && auth()->id() === $p->id_user)

                <a href="{{ route('feedback.create',$p) }}"
                   class="block text-center bg-green-600 text-white py-2 sm:py-3 rounded-xl hover:bg-green-700 mb-3 text-sm sm:text-base">
                    Donner un feedback
                </a>

                @endif


                <a href="{{ route('public.track.form') }}"
                   class="block text-center border py-2 sm:py-3 rounded-xl hover:bg-gray-50 text-sm sm:text-base">
                    Suivi public
                </a>

            </div>

        </div>

    </div>

    @else

    <div class="bg-white rounded-2xl sm:rounded-3xl shadow p-8 sm:p-12 text-center text-gray-500">
        Plainte non trouvée
    </div>

    @endif

</div>

@endsection