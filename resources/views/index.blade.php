@extends('base.base')

@section('title', 'Accueil - Plateforme de Plaintes')

@section('content')
<div class="bg-gradient-to-r from-royal-blue-600 to-royal-blue-800 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Plateforme de Gestion des Plaintes</h1>
        <p class="text-xl md:text-2xl mb-8 text-blue-100">Signalez vos problèmes aux services publics et suivez leur résolution</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('complaints.create') }}" class="bg-white text-royal-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-blue-100 transition-colors">
                Soumettre une plainte
            </a>
            @guest
                <a href="{{ route('auth.register') }}" class="bg-royal-blue-500 text-white px-8 py-3 rounded-lg font-bold hover:bg-royal-blue-400 transition-colors border-2 border-white">
                    Créer un compte
                </a>
            @endguest
            @auth
                <a href="{{ route('dashboard') }}" class="bg-royal-blue-500 text-white px-8 py-3 rounded-lg font-bold hover:bg-royal-blue-400 transition-colors border-2 border-white">
                    Mon tableau de bord
                </a>
            @endauth
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-12 text-royal-blue-700">Comment ça marche ?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="w-16 h-16 bg-royal-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">📝</span>
            </div>
            <h3 class="text-xl font-bold mb-2 text-royal-blue-700">1. Décrivez votre problème</h3>
            <p class="text-gray-600">Remplissez le formulaire avec les détails de votre plainte concernant un service public.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="w-16 h-16 bg-royal-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">📋</span>
            </div>
            <h3 class="text-xl font-bold mb-2 text-royal-blue-700">2. Suivez l'évolution</h3>
            <p class="text-gray-600">Recevez des notifications sur l'avancement de votre plainte et les réponses des agents.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="w-16 h-16 bg-royal-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">✅</span>
            </div>
            <h3 class="text-xl font-bold mb-2 text-royal-blue-700">3. Obtenez une solution</h3>
            <p class="text-gray-600">Les services publics traitent votre demande et vous informent de la résolution.</p>
        </div>
    </div>
</div>

<div class="bg-royal-blue-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-royal-blue-700">Services concernés</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <span class="text-4xl">💧</span>
                <p class="mt-2 font-medium">Eau</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <span class="text-4xl">⚡</span>
                <p class="mt-2 font-medium">Électricité</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <span class="text-4xl">🛣️</span>
                <p class="mt-2 font-medium">Voirie</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <span class="text-4xl">🗑️</span>
                <p class="mt-2 font-medium">Propreté</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <span class="text-4xl">🏥</span>
                <p class="mt-2 font-medium">Santé</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <span class="text-4xl">🏫</span>
                <p class="mt-2 font-medium">Éducation</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <span class="text-4xl">👮</span>
                <p class="mt-2 font-medium">Sécurité</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <span class="text-4xl">📋</span>
                <p class="mt-2 font-medium">Administration</p>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-16">
    <div class="bg-royal-blue-600 text-white rounded-lg p-8 text-center">
        <h2 class="text-2xl font-bold mb-4">Prêt à signaler un problème ?</h2>
        <p class="mb-6 text-blue-100">Rejoignez des milliers de citoyens qui améliorent les services publics.</p>
        @guest
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('auth.register') }}" class="bg-white text-royal-blue-600 px-6 py-3 rounded-lg font-bold hover:bg-blue-100 transition-colors">
                    Créer un compte gratuit
                </a>
                <a href="{{ route('auth.login') }}" class="bg-royal-blue-500 text-white px-6 py-3 rounded-lg font-bold hover:bg-royal-blue-400 transition-colors border-2 border-white">
                    Se connecter
                </a>
            </div>
        @endguest
        @auth
            <a href="{{ route('complaints.create') }}" class="bg-white text-royal-blue-600 px-6 py-3 rounded-lg font-bold hover:bg-blue-100 transition-colors inline-block">
                Soumettre une plainte
            </a>
        @endauth
    </div>
</div>
@endsection