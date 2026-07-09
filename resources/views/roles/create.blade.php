@extends('base.admin')

@section('title', 'Créer un rôle')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-royal-blue-700">Créer un rôle</h1>
            <p class="text-gray-600 mt-3">Définissez un nouveau rôle pour le système</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-xl p-8 max-w-2xl mx-auto border border-gray-200">
            <form method="POST" action="{{ route('roles.store') }}" class="space-y-6">
                @csrf

                <!-- Champ Nom du rôle -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nom du rôle</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        placeholder="Ex: Agent, Super Admin..."
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500 transition" />
                    @error('name') 
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-4">
                    <a href="{{ route('roles.index') }}" 
                       class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-royal-blue-600 text-white py-3 rounded-lg font-semibold shadow hover:bg-royal-blue-700 transition-colors">
                        ➕ Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
