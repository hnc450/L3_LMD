@extends('base.base')

@section('title', 'Réinitialisation du mot de passe')

@section('content')
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-blue-800">Réinitialisation du mot de passe</h2>
            <p class="mt-2 text-gray-600">Entrez votre nouveau mot de passe</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="bg-white p-8 rounded-2xl shadow-lg space-y-6">
            @csrf
            @include('layouts.alerts')

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse e-mail</label>
                <input id="email" name="email" type="email" required value="{{ $email ?? old('email') }}"
                       class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                <input id="password" name="password" type="password" required
                       class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-700 text-white py-3 rounded-xl font-semibold hover:bg-blue-800">
                Réinitialiser le mot de passe
            </button>

            <p class="text-center text-sm">
                <a href="{{ route('auth.login') }}" class="text-blue-600 hover:underline">Retour à la connexion</a>
            </p>
        </form>
    </div>
</div>
@endsection
