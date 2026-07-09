@extends('base.base')

@section('title', 'Accueil - Plateforme de Gestion des Plaintes')

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500">

    <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-6 py-24 relative z-10">

        <div class="grid lg:grid-cols-2 gap-14 items-center">

            <div>

                <span class="bg-white/20 px-4 py-2 rounded-full text-sm font-semibold">
                    🇨🇩 Plateforme citoyenne
                </span>

                <h1 class="mt-8 text-5xl lg:text-6xl font-extrabold text-white leading-tight">

                    Faites entendre votre voix.

                </h1>

                <p class="mt-6 text-blue-100 text-lg leading-8">

                    Déclarez rapidement un problème rencontré auprès des services publics,
                    suivez son évolution et participez à l'amélioration des services destinés à tous les citoyens.

                </p>

                <div class="flex flex-wrap gap-4 mt-10">

                    <a href="{{ route('complaints.create') }}"
                        class="px-8 py-4 bg-white text-blue-700 rounded-xl font-bold shadow-lg hover:scale-105 transition">

                        Soumettre une plainte

                    </a>

                    @guest

                    <a href="{{ route('auth.register') }}"
                        class="px-8 py-4 border-2 border-white text-white rounded-xl font-semibold hover:bg-white hover:text-blue-700 transition">

                        Créer un compte

                    </a>

                    @else

                    <a href="{{ route('dashboard') }}"
                        class="px-8 py-4 border-2 border-white text-white rounded-xl font-semibold hover:bg-white hover:text-blue-700 transition">

                        Tableau de bord

                    </a>

                    @endguest

                </div>

            </div>

            <div>

                <img
                    src="https://illustrations.popsy.co/white/digital-nomad.svg"
                    class="w-full max-w-xl mx-auto">

            </div>

        </div>

    </div>

</section>

<!-- STATISTIQUES -->

<section class="-mt-14 relative z-20">

    <div class="container mx-auto px-6">

        <div class="grid md:grid-cols-4 gap-6">

            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                <h2 class="text-4xl font-bold text-blue-700">15K+</h2>

                <p class="text-gray-500 mt-2">Plaintes</p>

            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                <h2 class="text-4xl font-bold text-blue-700">93%</h2>

                <p class="text-gray-500 mt-2">Résolues</p>

            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                <h2 class="text-4xl font-bold text-blue-700">250+</h2>

                <p class="text-gray-500 mt-2">Agents</p>

            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                <h2 class="text-4xl font-bold text-blue-700">24/7</h2>

                <p class="text-gray-500 mt-2">Disponible</p>

            </div>

        </div>

    </div>

</section>

<!-- COMMENT ÇA MARCHE -->

<section class="py-24 bg-gray-50">

<div class="container mx-auto px-6">

<h2 class="text-4xl font-bold text-center text-gray-800">

Comment ça fonctionne ?

</h2>

<p class="text-center text-gray-500 mt-3">

Déclarez un problème en quelques minutes.

</p>

<div class="grid lg:grid-cols-3 gap-10 mt-16">

<div class="bg-white rounded-3xl shadow-lg p-10 hover:-translate-y-2 transition">

<div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-4xl">

📝

</div>

<h3 class="text-2xl font-bold mt-8">

Déclarez

</h3>

<p class="text-gray-600 mt-4">

Décrivez votre problème avec précision en ajoutant éventuellement des photos.

</p>

</div>

<div class="bg-white rounded-3xl shadow-lg p-10 hover:-translate-y-2 transition">

<div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-4xl">

📍

</div>

<h3 class="text-2xl font-bold mt-8">

Suivez

</h3>

<p class="text-gray-600 mt-4">

Consultez l'évolution de votre dossier et recevez les notifications.

</p>

</div>

<div class="bg-white rounded-3xl shadow-lg p-10 hover:-translate-y-2 transition">

<div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-4xl">

✅

</div>

<h3 class="text-2xl font-bold mt-8">

Résolution

</h3>

<p class="text-gray-600 mt-4">

Les autorités prennent en charge votre demande jusqu'à sa résolution.

</p>

</div>

</div>

</div>

</section>

<!-- SERVICES -->

<section class="py-24">

<div class="container mx-auto px-6">

<h2 class="text-4xl font-bold text-center">

Services concernés

</h2>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">

@foreach([
['💧','Eau'],
['⚡','Électricité'],
['🛣️','Voirie'],
['🗑️','Propreté'],
['🏥','Santé'],
['🏫','Éducation'],
['👮','Sécurité'],
['📑','Administration']
] as $item)

<div class="rounded-2xl border bg-white p-8 text-center shadow hover:shadow-xl transition">

<div class="text-5xl">

{{ $item[0] }}

</div>

<h3 class="mt-5 text-lg font-semibold">

{{ $item[1] }}

</h3>

</div>

@endforeach

</div>

</div>

</section>

<!-- CTA -->

<section class="py-24">

<div class="container mx-auto px-6">

<div class="rounded-[40px] bg-gradient-to-r from-blue-700 to-blue-500 text-white p-16 text-center shadow-2xl">

<h2 class="text-4xl font-bold">

Votre voix compte.

</h2>

<p class="mt-5 text-blue-100 max-w-3xl mx-auto">

Chaque plainte contribue à améliorer la qualité des services publics.

Ensemble, construisons une administration plus efficace.

</p>

<div class="mt-10">

@guest

<a href="{{ route('auth.register') }}"
class="bg-white text-blue-700 px-10 py-4 rounded-xl font-bold shadow hover:scale-105 transition">

Créer un compte gratuitement

</a>

@else

<a href="{{ route('complaints.create') }}"
class="bg-white text-blue-700 px-10 py-4 rounded-xl font-bold shadow hover:scale-105 transition">

Déposer une plainte

</a>

@endguest

</div>

</div>

</div>

</section>

@endsection