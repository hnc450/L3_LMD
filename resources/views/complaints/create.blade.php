@extends('base.base')

@section('title', 'Soumettre une plainte - Plateforme de Plaintes')

@section('content')
<div class="min-h-[calc(100vh-200px)] py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-6 sm:mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-royal-blue-700">Soumettre une plainte</h2>
            <p class="mt-2 text-gray-600 text-sm sm:text-base">Décrivez votre problème concernant un service public</p>
        </div>
        
        @guest
            <div class="bg-yellow-50 border border-yellow-200 p-6 sm:p-8 rounded-lg text-center">
                <i class="fa-solid fa-lock text-3xl sm:text-4xl text-yellow-600 mb-4"></i>
                <h3 class="text-lg sm:text-xl font-semibold text-yellow-800 mb-2">Connexion requise</h3>
                <p class="text-gray-600 mb-6 text-sm sm:text-base">Vous devez être connecté pour soumettre une plainte.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('auth.login') }}" class="px-6 py-3 bg-royal-blue-600 text-white rounded-lg hover:bg-royal-blue-700 transition">
                        Se connecter
                    </a>
                    <a href="{{ route('auth.register') }}" class="px-6 py-3 border border-royal-blue-600 text-royal-blue-600 rounded-lg hover:bg-royal-blue-50 transition">
                        Créer un compte
                    </a>
                </div>
            </div>
        @else
            <form class="bg-white p-6 sm:p-8 rounded-lg shadow-lg space-y-6" method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
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
                <div>
                    <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service concerné *</label>
                    <select id="service" name="service" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500">
                        <option value="">Sélectionnez un service</option>
                        @forelse($services as $service)
                            <option value="{{ $service->id }}" {{ (old('service') == $service->id) || ($serviceId == $service->id) ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @empty
                            <option value="" disabled>No services available</option>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre de la plainte *</label>
                    <input id="title" name="title" type="text" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="Résumé court du problème" value="{{ old('title') }}">
                </div>
                
      
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description détaillée *</label>
                    <textarea id="description" name="description" rows="5" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="Décrivez en détail le problème, la localisation, et les circonstances...">{{ old('description') }}</textarea>
                </div>
                
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                    <input id="location" name="location" type="text" 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="Adresse ou quartier" value="{{ old('location') }}">
                </div>
                
                <div>
                    <label for="piece_jointe" class="block text-sm font-medium text-gray-700 mb-1">Pièce jointe (optionnel)</label>
                    <input id="piece_jointe" name="piece_jointe" type="file" 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        accept="image/*,.pdf,.doc,.docx">
                    <p class="text-xs text-gray-500 mt-1">Formats acceptés: JPG, PNG, PDF, DOC (max 5MB)</p>
                </div>
                
                <div>
                    <label for="priorite" class="block text-sm font-medium text-gray-700 mb-1">Priorité</label>
                    <select id="priorite" name="priorite" 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500">
                        <option value="normale" selected>Normale</option>
                        <option value="haute">Haute</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>
            </div>
            
            <div class="flex items-center">
                <input id="confirmation" name="confirmation" type="checkbox" required 
                    class="h-4 w-4 text-royal-blue-600 focus:ring-royal-blue-500 border-gray-300 rounded">
                <label for="confirmation" class="ml-2 block text-sm text-gray-700">
                    Je certifie que les informations fournies sont exactes
                </label>
            </div>
            
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                        class="flex-1 py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-royal-blue-600 hover:bg-royal-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-blue-500 transition-colors">
                        Soumettre la plainte
                    </button>
                    <a href="{{ route('index') }}" 
                        class="flex-1 py-3 px-4 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-blue-500 transition-colors text-center">
                        Annuler
                    </a>
                </div>
            </form>
        @endguest
    </div>
</div>
@endsection
