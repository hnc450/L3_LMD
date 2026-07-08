@extends('base.user')

@section('title', 'Tableau de bord - Citoyen')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-royal-blue-700">Tableau de bord citoyen</h1>
            <p class="text-gray-600 mt-2">Gérez et suivez vos plaintes</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-royal-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📋</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total plaintes</p>
                        <p class="text-2xl font-bold text-royal-blue-700">{{ $complaints->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">⏳</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">En cours</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $en_cours ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">✅</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Résolues</p>
                        <p class="text-2xl font-bold text-green-600">{{ $resolues ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📝</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Enregistrées</p>
                        <p class="text-2xl font-bold text-red-600">{{ $enregistrees ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-xl font-bold text-royal-blue-700 mb-4">Actions rapides</h2>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('complaint.create') }}" class="bg-royal-blue-600 text-white px-6 py-3 rounded-lg hover:bg-royal-blue-700 transition-colors flex items-center">
                    <span class="mr-2">➕</span> Nouvelle plainte
                </a>
                <a href="{{ route('notifications.index') }}" class="bg-white border-2 border-royal-blue-600 text-royal-blue-600 px-6 py-3 rounded-lg hover:bg-royal-blue-50 transition-colors flex items-center">
                    <span class="mr-2">🔔</span> Notifications
                </a>
            </div>
        </div>
        
        <!-- Complaints List -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-royal-blue-700">Mes plaintes</h2>
                    <div class="flex gap-2">
                        <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="enregistree">Enregistrée</option>
                            <option value="en_cours">En cours</option>
                            <option value="resolue">Résolue</option>
                        </select>
                        <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                            <option value="">Tous les services</option>
                            <option value="eau">Eau</option>
                            <option value="electricite">Électricité</option>
                            <option value="voirie">Voirie</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($complaints ?? [] as $complaint)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-royal-blue-600">#{{ $complaint->id ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $complaint->titre ?? 'Sans titre' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ ucfirst($complaint->service ?? 'N/A') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($complaint->statut ?? 'enregistree')
                                    @case('enregistree')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Enregistrée</span>
                                        @break
                                    @case('en_cours')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En cours</span>
                                        @break
                                    @case('resolue')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Résolue</span>
                                        @break
                                    @default
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $complaint->statut }}</span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $complaint->created_at ? $complaint->created_at->format('d/m/Y') : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('complaint.show', $complaint->id) }}" class="text-royal-blue-600 hover:text-royal-blue-900 font-medium">Voir détails</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg">Aucune plainte pour le moment</p>
                                <a href="{{ route('complaint.create') }}" class="text-royal-blue-600 hover:text-royal-blue-900 font-medium mt-2 inline-block">Soumettre votre première plainte</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($complaints) && $complaints->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $complaints->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection