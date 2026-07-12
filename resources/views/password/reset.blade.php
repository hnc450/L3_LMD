@extends('base.base')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-blue-800">Mot de passe oublié</h2>
            <p class="mt-2 text-gray-600">Entrez votre e-mail pour recevoir un lien de réinitialisation</p>
        </div>

        <form method="POST" action="{{ route('auth.password.email') }}" class="bg-white p-8 rounded-2xl shadow-lg space-y-6">
            @csrf
            @include('layouts.alerts')

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse e-mail</label>
                <input id="email" name="email" type="email" required value="{{ old('email') }}"
                       class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-700 text-white py-3 rounded-xl font-semibold hover:bg-blue-800">
                Envoyer le lien
            </button>

            <p class="text-center text-sm">
                <a href="{{ route('auth.login') }}" class="text-blue-600 hover:underline">Retour à la connexion</a>
            </p>
        </form>
    </div>
</div>
@endsection
