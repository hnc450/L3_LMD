@extends('base.admin')

@section('title', 'Logs et Traçabilité - Plateforme de Plaintes')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-royal-blue-700">Logs et Traçabilité</h1>
            <p class="text-gray-600 mt-2">Historique des actions effectuées sur la plateforme</p>
        </div>
        
        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow-lg mb-6">
            <div class="flex gap-4 flex-wrap items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type d'action</label>
                    <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                        <option value="">Tous les types</option>
                        <option value="create">Création</option>
                        <option value="update">Mise à jour</option>
                        <option value="delete">Suppression</option>
                        <option value="assign">Assignation</option>
                        <option value="login">Connexion</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Utilisateur</label>
                    <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                        <option value="">Tous les utilisateurs</option>
                        <option value="admin">Administrateurs</option>
                        <option value="agent">Agents</option>
                        <option value="citoyen">Citoyens</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                    <input type="date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                    <input type="date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                </div>
                <button class="bg-royal-blue-600 text-white px-4 py-2 rounded-lg hover:bg-royal-blue-700 transition-colors">
                    Filtrer
                </button>
            </div>
        </div>
        
        <!-- Logs Table -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-royal-blue-700">Historique des actions</h2>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                        📥 Exporter les logs
                    </button>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Heure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Détails</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($logs ?? [] as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-royal-blue-100 rounded-full flex items-center justify-center mr-2">
                                        <span class="text-sm">{{ substr($log->user->nom ?? 'U', 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $log->user->nom ?? 'N/A' }} {{ $log->user->prenom ?? '' }}</p>
                                        <p class="text-xs text-gray-500">{{ $log->user->role ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($log->action ?? 'unknown')
                                    @case('create')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Création</span>
                                        @break
                                    @case('update')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Mise à jour</span>
                                        @break
                                    @case('delete')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Suppression</span>
                                        @break
                                    @case('assign')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Assignation</span>
                                        @break
                                    @case('login')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Connexion</span>
                                        @break
                                    @default
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $log->action }}</span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                {{ $log->description ?? 'Aucun détail' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log->ip_address ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg">Aucun log disponible</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($logs) && $logs->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
        
        <!-- Recent Activity Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-bold text-royal-blue-700 mb-4">Actions aujourd'hui</h3>
                <p class="text-3xl font-bold text-royal-blue-600">{{ $today_actions ?? 0 }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $today_users ?? 0 }} utilisateurs actifs</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-bold text-royal-blue-700 mb-4">Cette semaine</h3>
                <p class="text-3xl font-bold text-royal-blue-600">{{ $week_actions ?? 0 }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $week_users ?? 0 }} utilisateurs actifs</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-bold text-royal-blue-700 mb-4">Ce mois</h3>
                <p class="text-3xl font-bold text-royal-blue-600">{{ $month_actions ?? 0 }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $month_users ?? 0 }} utilisateurs actifs</p>
            </div>
        </div>
    </div>
</div>
@endsection
