@extends('base.base')

@section('title', 'Accueil - Plateforme de Gestion des Plaintes')

@section('content')

<section class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500">
    <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-6 py-24 relative z-10">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            <div>
                <span class="inline-flex items-center gap-2 bg-white/20 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fa-solid fa-landmark"></i> Plateforme citoyenne
                </span>
                <h1 class="mt-8 text-5xl lg:text-6xl font-extrabold text-white leading-tight">Faites entendre votre voix.</h1>
                <p class="mt-6 text-blue-100 text-lg leading-8">
                    Déclarez rapidement un problème rencontré auprès des services publics,
                    suivez son évolution et participez à l'amélioration des services destinés à tous les citoyens.
                </p>
                <div class="flex flex-wrap gap-4 mt-10">
                    <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-700 rounded-xl font-bold shadow-lg hover:scale-105 transition">
                        <i class="fa-solid fa-file-circle-plus"></i> Soumettre une plainte
                    </a>
                    <a href="{{ route('public.track.form') }}" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white/70 text-white rounded-xl font-semibold hover:bg-white/10 transition">
                        <i class="fa-solid fa-magnifying-glass"></i> Suivre une plainte
                    </a>
                    @guest
                    <a href="{{ route('auth.register') }}" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white text-white rounded-xl font-semibold hover:bg-white hover:text-blue-700 transition">
                        <i class="fa-solid fa-user-plus"></i> Créer un compte
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white text-white rounded-xl font-semibold hover:bg-white hover:text-blue-700 transition">
                        <i class="fa-solid fa-gauge-high"></i> Tableau de bord
                    </a>
                    @endguest
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="bg-white/10 backdrop-blur rounded-3xl p-10 border border-white/20">
                    <i class="fa-solid fa-shield-halved text-6xl text-white/80"></i>
                    <p class="text-white text-xl font-semibold mt-6">Transparence & traçabilité</p>
                    <p class="text-blue-100 mt-2">Chaque plainte reçoit un code unique de suivi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="-mt-14 relative z-20">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <i class="fa-solid fa-folder-open text-3xl text-blue-700 mb-3"></i>
                <h2 class="text-4xl font-bold text-blue-700">{{ number_format($totalPlaintes) }}</h2>
                <p class="text-gray-500 mt-2">Plaintes enregistrées</p>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <i class="fa-solid fa-circle-check text-3xl text-green-600 mb-3"></i>
                <h2 class="text-4xl font-bold text-green-600">{{ $tauxResolution }}%</h2>
                <p class="text-gray-500 mt-2">Taux de résolution</p>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <i class="fa-solid fa-user-tie text-3xl text-indigo-600 mb-3"></i>
                <h2 class="text-4xl font-bold text-indigo-600">{{ $totalAgents }}</h2>
                <p class="text-gray-500 mt-2">Agents actifs</p>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <i class="fa-solid fa-building text-3xl text-cyan-600 mb-3"></i>
                <h2 class="text-4xl font-bold text-cyan-600">{{ $totalServices }}</h2>
                <p class="text-gray-500 mt-2">Services publics</p>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center text-gray-800">Comment ça fonctionne ?</h2>
        <p class="text-center text-gray-500 mt-3">Déclarez un problème en quelques minutes.</p>
        <div class="grid lg:grid-cols-3 gap-10 mt-16">
            @foreach([
                ['icon' => 'fa-file-pen', 'title' => 'Déclarez', 'desc' => 'Décrivez votre problème avec précision en ajoutant éventuellement des photos.'],
                ['icon' => 'fa-location-dot', 'title' => 'Suivez', 'desc' => 'Consultez l\'évolution de votre dossier et recevez les notifications.'],
                ['icon' => 'fa-circle-check', 'title' => 'Résolution', 'desc' => 'Les autorités prennent en charge votre demande jusqu\'à sa résolution.'],
            ] as $step)
            <div class="bg-white rounded-3xl shadow-lg p-10 hover:-translate-y-2 transition">
                <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center">
                    <i class="fa-solid {{ $step['icon'] }} text-2xl text-blue-700"></i>
                </div>
                <h3 class="text-2xl font-bold mt-8">{{ $step['title'] }}</h3>
                <p class="text-gray-600 mt-4">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-24">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center">Services concernés</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">
            @forelse($services as $service)
            <a href="{{ route('complaints.create', ['service' => $service->id]) }}"
               class="rounded-2xl border bg-white p-8 text-center shadow hover:shadow-xl hover:-translate-y-1 transition">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-100 flex items-center justify-center">
                    <i class="fa-solid fa-building-columns text-2xl text-blue-700"></i>
                </div>
                <h3 class="mt-5 text-lg font-semibold">{{ $service->name }}</h3>
                <p class="text-sm text-gray-500 mt-2">{{ $service->plaintes_count }} plainte(s)</p>
            </a>
            @empty
            <p class="col-span-full text-center text-gray-500">Aucun service disponible pour le moment.</p>
            @endforelse
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('services') }}" class="text-blue-700 font-semibold hover:underline">
                <i class="fa-solid fa-arrow-right mr-1"></i> Voir tous les services
            </a>
        </div>
    </div>
</section>

<section class="py-24">
    <div class="container mx-auto px-6">
        <div class="rounded-[40px] bg-gradient-to-r from-blue-700 to-blue-500 text-white p-16 text-center shadow-2xl">
            <i class="fa-solid fa-bullhorn text-4xl mb-4"></i>
            <h2 class="text-4xl font-bold">Votre voix compte.</h2>
            <p class="mt-5 text-blue-100 max-w-3xl mx-auto">
                Chaque plainte contribue à améliorer la qualité des services publics.
                Ensemble, construisons une administration plus efficace.
            </p>
            <div class="mt-10">
                @guest
                <a href="{{ route('auth.register') }}" class="inline-flex items-center gap-2 bg-white text-blue-700 px-10 py-4 rounded-xl font-bold shadow hover:scale-105 transition">
                    <i class="fa-solid fa-user-plus"></i> Créer un compte gratuitement
                </a>
                @else
                <a href="{{ route('complaints.create') }}" class="inline-flex items-center gap-2 bg-white text-blue-700 px-10 py-4 rounded-xl font-bold shadow hover:scale-105 transition">
                    <i class="fa-solid fa-file-circle-plus"></i> Déposer une plainte
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>

@endsection
