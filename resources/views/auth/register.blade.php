@extends('base.base')

@section("title", "Inscription - Plateforme de Plaintes")

@section("content")
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-royal-blue-700">Créer un compte</h2>
            <p class="mt-2 text-gray-600">Rejoignez la plateforme pour signaler vos plaintes</p>
        </div>
        
        <form class="mt-8 space-y-6 bg-white p-8 rounded-lg shadow-lg" method="POST" action="{{ route('auth.register') }}">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input id="nom" name="nom" type="text" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                            placeholder="Votre nom" value="{{ old('nom') }}">
                    </div>
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input id="prenom" name="prenom" type="text" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                            placeholder="Votre prénom" value="{{ old('prenom') }}">
                    </div>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="votre@email.com" value="{{ old('email') }}">
                </div>
                
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input id="telephone" name="telephone" type="tel" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="+221 77 123 45 67" value="{{ old('telephone') }}">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input id="password" name="password" type="password" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="••••••••">
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="••••••••">
                </div>
            </div>
            
            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-royal-blue-600 hover:bg-royal-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-blue-500 transition-colors">
                    S'inscrire
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Déjà inscrit ? 
                    <a href="{{ route('auth.login') }}" class="font-medium text-royal-blue-600 hover:text-royal-blue-500">
                        Se connecter
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection