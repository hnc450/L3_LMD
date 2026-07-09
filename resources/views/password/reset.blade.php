@extends('base.base')
@section('title','Réinitialiser le mot de passe')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="container mx-auto px-6">
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-royal-blue-700">Réinitialiser le mot de passe</h1>
            <p class="text-gray-600 mt-3">Entrez votre adresse email pour recevoir un lien de réinitialisation</p>
        </div>

        <div class="bg-white rounded-xl shadow-xl p-8 max-w-md mx-auto border border-gray-200">
            <form method="POST" action="{{ '#' }}" class="space-y-6">
                @csrf

                <!-- Champ Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        placeholder="ex: utilisateur@exemple.com"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500 transition" />
                    @error('email') 
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Bouton -->
                <button type="submit" 
                        class="w-full bg-royal-blue-600 text-white py-3 rounded-lg font-semibold shadow hover:bg-royal-blue-700 transition-colors">
                    📧 Envoyer le lien de réinitialisation
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
