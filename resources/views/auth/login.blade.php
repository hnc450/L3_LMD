@extends('base.base')

@section('title', 'Connexion - Plateforme de Plaintes')

@section('content')
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-royal-blue-700">Connexion</h2>
            <p class="mt-2 text-gray-600">Accédez à votre espace pour gérer vos plaintes</p>
        </div>
        
        <form class="mt-8 space-y-6 bg-white p-8 rounded-lg shadow-lg" method="POST" action="{{ route('auth.login') }}">
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
            
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="votre@email.com" value="{{ old('email') }}">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input id="password" name="password" type="password" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="••••••••">
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                            class="h-4 w-4 text-royal-blue-600 focus:ring-royal-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>
                    
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-royal-blue-600 hover:text-royal-blue-500">
                            Mot de passe oublié ?
                        </a>
                    </div>
                </div>
            </div>
            
            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-royal-blue-600 hover:bg-royal-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-blue-500 transition-colors">
                    Se connecter
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Pas encore inscrit ? 
                    <a href="{{ route('auth.register') }}" class="font-medium text-royal-blue-600 hover:text-royal-blue-500">
                        Créer un compte
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
