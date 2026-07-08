@extends('base.user')

@section('title', 'Détail de la plainte - Plateforme de Plaintes')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-royal-blue-600 hover:text-royal-blue-900 font-medium flex items-center">
                <span class="mr-2">←</span> Retour au tableau de bord
            </a>
        </div>
        
        @if(isset($complaint))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Complaint Details -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-royal-blue-700">{{ $complaint->titre }}</h1>
                            <p class="text-sm text-gray-500 mt-1">Référence #{{ $complaint->id }}</p>
                        </div>
                        @switch($complaint->statut ?? 'enregistree')
                            @case('enregistree')
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-800">Enregistrée</span>
                                @break
                            @case('en_cours')
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">En cours</span>
                                @break
                            @case('resolue')
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">Résolue</span>
                                @break
                            @default
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">{{ $complaint->statut }}</span>
                        @endswitch
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Service</p>
                            <p class="font-medium text-gray-900">{{ ucfirst($complaint->service ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Priorité</p>
                            <p class="font-medium text-gray-900">{{ ucfirst($complaint->priorite ?? 'Normale') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date de soumission</p>
                            <p class="font-medium text-gray-900">{{ $complaint->created_at ? $complaint->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Localisation</p>
                            <p class="font-medium text-gray-900">{{ $complaint->localisation ?? 'Non spécifiée' }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $complaint->description ?? 'Aucune description' }}</p>
                    </div>
                    
                    @if($complaint->piece_jointe)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Pièce jointe</h3>
                        <a href="#" class="inline-flex items-center text-royal-blue-600 hover:text-royal-blue-900">
                            <span class="mr-2">📎</span> Voir le fichier
                        </a>
                    </div>
                    @endif
                </div>
                
                <!-- Responses/Updates -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-royal-blue-700 mb-4">Historique des mises à jour</h2>
                    
                    <div class="space-y-4">
                        <!-- Initial submission -->
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-royal-blue-100 rounded-full flex items-center justify-center mr-4">
                                <span>📝</span>
                            </div>
                            <div class="flex-1">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="font-medium text-gray-900">Plainte soumise</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $complaint->created_at ? $complaint->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if(isset($responses))
                        @foreach($responses as $response)
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <span>💬</span>
                            </div>
                            <div class="flex-1">
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <p class="font-medium text-gray-900">{{ $response->auteur ?? 'Agent' }}</p>
                                    <p class="text-sm text-gray-700 mt-1">{{ $response->message ?? '' }}</p>
                                    <p class="text-xs text-gray-500 mt-2">{{ $response->created_at ? $response->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-royal-blue-700 mb-4">Actions</h3>
                    <div class="space-y-3">
                        @if($complaint->statut !== 'resolue')
                        <button class="w-full bg-royal-blue-600 text-white py-2 px-4 rounded-lg hover:bg-royal-blue-700 transition-colors">
                            Contacter le support
                        </button>
                        @endif
                        @if($complaint->statut === 'resolue')
                        <a href="{{ route('feedback.create', $complaint->id) }}" class="block w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors text-center">
                            Donner un feedback
                        </a>
                        @endif
                        <button class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                            Imprimer
                        </button>
                    </div>
                </div>
                
                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-royal-blue-700 mb-4">Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-royal-blue-600 rounded-full mr-3"></div>
                            <div>
                                <p class="font-medium text-gray-900">Soumission</p>
                                <p class="text-xs text-gray-500">{{ $complaint->created_at ? $complaint->created_at->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        @if($complaint->statut !== 'enregistree')
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                            <div>
                                <p class="font-medium text-gray-900">En cours de traitement</p>
                                <p class="text-xs text-gray-500">{{ $complaint->updated_at ? $complaint->updated_at->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        @endif
                        @if($complaint->statut === 'resolue')
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <div>
                                <p class="font-medium text-gray-900">Résolution</p>
                                <p class="text-xs text-gray-500">{{ $complaint->updated_at ? $complaint->updated_at->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <p class="text-xl text-gray-600">Plainte non trouvée</p>
            <a href="{{ route('dashboard') }}" class="text-royal-blue-600 hover:text-royal-blue-900 font-medium mt-4 inline-block">Retour au tableau de bord</a>
        </div>
        @endif
    </div>
</div>
@endsection
