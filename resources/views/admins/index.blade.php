@extends('base.admin')

@section('title', 'Interface Administrateur - Plateforme de Plaintes')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-royal-blue-700">Interface Administrateur</h1>
            <p class="text-gray-600 mt-2">Gérez toutes les plaintes et attribuez-les aux agents</p>
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
                        <p class="text-2xl font-bold text-royal-blue-700">{{ $total ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📝</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">En attente</p>
                        <p class="text-2xl font-bold text-red-600">{{ $en_attente ?? 0 }}</p>
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
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-xl font-bold text-royal-blue-700 mb-4">Actions rapides</h2>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('statistics.index') }}" class="bg-royal-blue-600 text-white px-6 py-3 rounded-lg hover:bg-royal-blue-700 transition-colors flex items-center">
                    <span class="mr-2">📊</span> Statistiques
                </a>
                <a href="{{ route('logs.index') }}" class="bg-white border-2 border-royal-blue-600 text-royal-blue-600 px-6 py-3 rounded-lg hover:bg-royal-blue-50 transition-colors flex items-center">
                    <span class="mr-2">📜</span> Logs et traçabilité
                </a>
                <a href="{{ route('agents.index') }}" class="bg-white border-2 border-royal-blue-600 text-royal-blue-600 px-6 py-3 rounded-lg hover:bg-royal-blue-50 transition-colors flex items-center">
                    <span class="mr-2">👥</span> Gérer les agents
                </a>
            </div>
        </div>
        
        <!-- Complaints Management -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <h2 class="text-xl font-bold text-royal-blue-700">Toutes les plaintes</h2>
                    <div class="flex gap-2 flex-wrap">
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
                            <option value="proprete">Propreté</option>
                            <option value="sante">Santé</option>
                            <option value="education">Éducation</option>
                            <option value="securite">Sécurité</option>
                            <option value="administration">Administration</option>
                        </select>
                        <input type="date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Citoyen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent assigné</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($complaints ?? [] as $complaint)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-royal-blue-600">#{{ $complaint->id ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $complaint->titre ?? 'Sans titre' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $complaint->user->nom ?? 'N/A' }} {{ $complaint->user->prenom ?? '' }}</td>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $complaint->agent->nom ?? 'Non assigné' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $complaint->created_at ? $complaint->created_at->format('d/m/Y') : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('complaint.show', $complaint->id) }}" class="text-royal-blue-600 hover:text-royal-blue-900 font-medium">Voir</a>
                                    <button onclick="openAssignModal({{ $complaint->id }})" class="text-green-600 hover:text-green-900 font-medium">Assigner</button>
                                    <button onclick="openStatusModal({{ $complaint->id }})" class="text-yellow-600 hover:text-yellow-900 font-medium">Statut</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg">Aucune plainte pour le moment</p>
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

<!-- Assign Modal -->
<div id="assignModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-royal-blue-700 mb-4">Assigner à un agent</h3>
        <form method="POST" action="{{ route('admin.assign') }}">
            @csrf
            <input type="hidden" name="complaint_id" id="assignComplaintId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Agent</label>
                <select name="agent_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                    <option value="">Sélectionnez un agent</option>
                    @foreach($agents ?? [] as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->nom }} {{ $agent->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-royal-blue-600 text-white py-2 px-4 rounded-lg hover:bg-royal-blue-700 transition-colors">Assigner</button>
                <button type="button" onclick="closeAssignModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition-colors">Annuler</button>
            </div>
        </form>
    </div>
</div>

<!-- Status Modal -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-royal-blue-700 mb-4">Mettre à jour le statut</h3>
        <form method="POST" action="{{ route('admin.update-status') }}">
            @csrf
            <input type="hidden" name="complaint_id" id="statusComplaintId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau statut</label>
                <select name="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                    <option value="enregistree">Enregistrée</option>
                    <option value="en_cours">En cours</option>
                    <option value="resolue">Résolue</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Réponse</label>
                <textarea name="reponse" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500" placeholder="Ajoutez une réponse..."></textarea>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-royal-blue-600 text-white py-2 px-4 rounded-lg hover:bg-royal-blue-700 transition-colors">Mettre à jour</button>
                <button type="button" onclick="closeStatusModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition-colors">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAssignModal(complaintId) {
    document.getElementById('assignComplaintId').value = complaintId;
    document.getElementById('assignModal').classList.remove('hidden');
    document.getElementById('assignModal').classList.add('flex');
}

function closeAssignModal() {
    document.getElementById('assignModal').classList.add('hidden');
    document.getElementById('assignModal').classList.remove('flex');
}

function openStatusModal(complaintId) {
    document.getElementById('statusComplaintId').value = complaintId;
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('statusModal').classList.add('flex');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('statusModal').classList.remove('flex');
}
</script>
@endsection