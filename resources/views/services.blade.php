@extends('base.base')

@section('title','Services publics - Gestion des plaintes')

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-blue-700 to-blue-500">

    <div class="absolute -top-24 -left-24 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-6 py-20 relative">

        <div class="text-center text-white max-w-3xl mx-auto">

            <span class="bg-white/20 px-4 py-2 rounded-full text-sm font-semibold">
                🇨🇩 Services publics
            </span>

            <h1 class="text-5xl font-extrabold mt-6">
                Choisissez le service concerné
            </h1>

            <p class="mt-6 text-blue-100 text-lg">
                Sélectionnez un domaine pour signaler un problème,
                suivre vos plaintes et contribuer à l'amélioration des services publics.
            </p>

        </div>

    </div>

</section>

<!-- STATISTIQUES -->

<section class="-mt-12 relative z-20">

    <div class="container mx-auto px-6">

        <div class="grid md:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                <h2 class="text-4xl font-bold text-blue-700">8</h2>

                <p class="text-gray-500 mt-2">
                    Services disponibles
                </p>

            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                <h2 class="text-4xl font-bold text-blue-700">24/7</h2>

                <p class="text-gray-500 mt-2">
                    Plateforme disponible
                </p>

            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                <h2 class="text-4xl font-bold text-blue-700">100%</h2>

                <p class="text-gray-500 mt-2">
                    Suivi en ligne
                </p>

            </div>

        </div>

    </div>

</section>

<!-- MESSAGE VISITEUR -->

@guest

<section class="py-12">

    <div class="container mx-auto px-6">

        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-8 flex flex-col md:flex-row justify-between items-center gap-6">

            <div>

                <h3 class="text-xl font-bold text-yellow-800">

                    Connectez-vous

                </h3>

                <p class="text-yellow-700 mt-2">

                    Créez un compte ou connectez-vous pour déposer une plainte,
                    consulter son évolution et recevoir des notifications.

                </p>

            </div>

            <a href="{{ route('login') }}"
                class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition">

                Se connecter

            </a>

        </div>

    </div>

</section>

@endguest

<!-- SERVICES -->

<section class="pb-24">

<div class="container mx-auto px-6">

<div class="flex justify-between items-center mb-12">

<div>

<h2 class="text-4xl font-bold text-gray-800">

Services disponibles

</h2>

<p class="text-gray-500 mt-2">

Choisissez un service pour déposer une plainte.

</p>

</div>

</div>

@php

$services = [

[
'emoji'=>'🏥',
'titre'=>'Santé publique',
'description'=>'Hôpitaux, centres de santé, personnel médical et soins.',
'route'=>'sante',
'color'=>'bg-red-100 text-red-600'
],

[
'emoji'=>'💧',
'titre'=>"Distribution d'eau",
'description'=>"Problèmes liés à la distribution ou à la qualité de l'eau.",
'route'=>'eau',
'color'=>'bg-cyan-100 text-cyan-600'
],

[
'emoji'=>'⚡',
'titre'=>'Électricité',
'description'=>"Coupures, facturation ou anomalies du réseau électrique.",
'route'=>'electricite',
'color'=>'bg-yellow-100 text-yellow-600'
],

[
'emoji'=>'🛣️',
'titre'=>'Voirie',
'description'=>'Routes dégradées, éclairage public, infrastructures.',
'route'=>'voirie',
'color'=>'bg-gray-100 text-gray-700'
],

[
'emoji'=>'🗑️',
'titre'=>'Assainissement',
'description'=>'Déchets, salubrité et collecte des ordures.',
'route'=>'proprete',
'color'=>'bg-green-100 text-green-600'
],

[
'emoji'=>'🏫',
'titre'=>'Éducation',
'description'=>'Écoles, universités et établissements publics.',
'route'=>'education',
'color'=>'bg-indigo-100 text-indigo-600'
]

];

@endphp

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

@foreach($services as $service)

<div class="bg-white rounded-3xl border shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-300 overflow-hidden">

<div class="h-2 bg-gradient-to-r from-blue-600 to-cyan-500"></div>

<div class="p-8">

<div class="flex items-center justify-between">

<div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl {{ $service['color'] }}">

{{ $service['emoji'] }}

</div>

<span class="text-xs font-semibold bg-blue-50 text-blue-700 px-3 py-1 rounded-full">

Service public

</span>

</div>

<h3 class="text-2xl font-bold mt-8">

{{ $service['titre'] }}

</h3>

<p class="text-gray-600 mt-4 leading-7">

{{ $service['description'] }}

</p>

<div class="mt-8">

@auth

<a href="{{ route('complaints.create',['service'=>$service['route']]) }}"
class="block text-center bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">

Déposer une plainte

</a>

@else

<a href="{{ route('login') }}"
class="block text-center bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">

Se connecter

</a>

@endauth

</div>

</div>

</div>

@endforeach

</div>

</div>

</section>

<!-- CTA -->

<section class="pb-24">

<div class="container mx-auto px-6">

<div class="rounded-[40px] bg-gradient-to-r from-blue-700 to-cyan-500 text-white p-16 text-center shadow-2xl">

<h2 class="text-4xl font-bold">

Un problème non répertorié ?

</h2>

<p class="text-blue-100 mt-4 max-w-2xl mx-auto">

Vous pouvez toujours déposer une plainte.
Notre équipe la redirigera automatiquement vers le service compétent.

</p>

<div class="mt-10">

<a href="{{ route('complaints.create') }}"
class="bg-white text-blue-700 px-10 py-4 rounded-xl font-bold shadow hover:scale-105 transition">

Créer une plainte

</a>

</div>

</div>

</div>

</section>

@endsection