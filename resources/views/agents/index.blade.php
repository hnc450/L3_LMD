@extends('base.agent')

@section('title', 'Interface Agent - Plateforme de Plaintes')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-royal-blue-700">Interface Agent</h1>
            <p class="text-gray-600 mt-2">Gérez les plaintes qui vous sont assignées</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-royal-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📋</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Assignées</p>
                        <p class="text-2xl font-bold text-royal-blue-700">{{ $assignees ?? 0 }}</p>
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
                        <span class="text-2xl">🔴</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Urgentes</p>
                        <p class="text-2xl font-bold text-red-600">{{ $urgentes ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Assigned Complaints -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <h2 class="text-xl font-bold text-royal-blue-700">Mes plaintes assignées</h2>
                    <div class="flex gap-2 flex-wrap">
                        <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="enregistree">Enregistrée</option>
                            <option value="en_cours">En cours</option>
                            <option value="resolue">Résolue</option>
                        </select>
                        <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                            <option value="">Toutes les priorités</option>
                            <option value="normale">Normale</option>
                            <option value="haute">Haute</option>
                            <option value="urgente">Urgente</option>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Citoyen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priorité</th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $complaint->user->nom ?? 'N/A' }} {{ $complaint->user->prenom ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ ucfirst($complaint->service ?? 'N/A') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($complaint->priorite ?? 'normale')
                                    @case('normale')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Normale</span>
                                        @break
                                    @case('haute')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Haute</span>
                                        @break
                                    @case('urgente')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgente</span>
                                        @break
                                    @default
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $complaint->priorite }}</span>
                                @endswitch
                            </td>
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
                                <div class="flex gap-2">
                                    <a href="{{ route('complaint.show', $complaint->id) }}" class="text-royal-blue-600 hover:text-royal-blue-900 font-medium">Voir</a>
                                    <button onclick="openResponseModal({{ $complaint->id }})" class="text-green-600 hover:text-green-900 font-medium">Répondre</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg">Aucune plainte assignée pour le moment</p>
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
        
        <!-- Action History -->
        <div class="bg-white rounded-lg shadow-lg mt-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-royal-blue-700">Historique de mes actions</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($actions ?? [] as $action)
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-royal-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span>📝</span>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="font-medium text-gray-900">{{ $action->type ?? 'Action' }} - Plainte #{{ $action->complaint_id ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-700 mt-1">{{ $action->description ?? '' }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ $action->created_at ? $action->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">Aucune action enregistrée</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Response Modal -->
<div id="responseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
        <h3 class="text-xl font-bold text-royal-blue-700 mb-4">Répondre à la plainte</h3>
        <form method="POST" action="{{ route('agent.respond') }}">
            @csrf
            <input type="hidden" name="complaint_id" id="responseComplaintId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau statut</label>
                <select name="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500">
                    <option value="en_cours">En cours</option>
                    <option value="resolue">Résolue</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Votre réponse</label>
                <textarea name="reponse" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500" placeholder="Décrivez les actions entreprises ou la solution apportée..."></textarea>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-royal-blue-600 text-white py-2 px-4 rounded-lg hover:bg-royal-blue-700 transition-colors">Envoyer</button>
                <button type="button" onclick="closeResponseModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition-colors">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
function openResponseModal(complaintId) {
    document.getElementById('responseComplaintId').value = complaintId;
    document.getElementById('responseModal').classList.remove('hidden');
    document.getElementById('responseModal').classList.add('flex');
}

function closeResponseModal() {
    document.getElementById('responseModal').classList.add('hidden');
    document.getElementById('responseModal').classList.remove('flex');
}
</script>
@endsection