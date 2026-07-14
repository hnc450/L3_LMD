@extends('base.agent')

@section('title', 'Interface Agent')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Mes plaintes assignées</h1>
            <p class="text-gray-500 text-sm sm:text-base">Répondez aux citoyens et mettez à jour les statuts</p>
        </div>
        <a href="{{ route('agent.rapport.create') }}" class="bg-blue-700 text-white px-4 sm:px-5 py-3 rounded-xl font-medium hover:bg-blue-800 text-sm">
            <i class="fa-solid fa-file-lines mr-2"></i>Soumettre un rapport
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([
            ['label' => 'Assignées', 'value' => $assignees ?? 0, 'color' => 'blue'],
            ['label' => 'En cours', 'value' => $en_cours ?? 0, 'color' => 'yellow'],
            ['label' => 'Résolues', 'value' => $resolues ?? 0, 'color' => 'green'],
            ['label' => 'Urgentes', 'value' => $urgentes ?? 0, 'color' => 'red'],
        ] as $s)
        <div class="bg-white rounded-2xl shadow p-4 lg:p-5 border-l-4 border-{{ $s['color'] }}-500">
            <p class="text-xs sm:text-sm text-gray-500">{{ $s['label'] }}</p>
            <p class="text-2xl sm:text-3xl font-bold">{{ $s['value'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs sm:text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-2 sm:px-4 py-3 text-left">Réf.</th>
                        <th class="px-2 sm:px-4 py-3 text-left">Titre</th>
                        <th class="px-2 sm:px-4 py-3 text-left hidden sm:table-cell">Citoyen</th>
                        <th class="px-2 sm:px-4 py-3 text-left hidden md:table-cell">Service</th>
                        <th class="px-2 sm:px-4 py-3 text-left hidden lg:table-cell">Priorité</th>
                        <th class="px-2 sm:px-4 py-3 text-left">Statut</th>
                        <th class="px-2 sm:px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($complaints ?? [] as $complaint)
                    <tr class="hover:bg-slate-50">
                        <td class="px-2 sm:px-4 py-3 font-mono text-blue-700 text-xs">{{ $complaint->code_suivi }}</td>
                        <td class="px-2 sm:px-4 py-3 font-medium truncate max-w-xs">{{ $complaint->title }}</td>
                        <td class="px-2 sm:px-4 py-3 hidden sm:table-cell">{{ $complaint->citoyenNom() }}</td>
                        <td class="px-2 sm:px-4 py-3 hidden md:table-cell">{{ $complaint->service?->name }}</td>
                        <td class="px-2 sm:px-4 py-3 hidden lg:table-cell">{{ ucfirst($complaint->priorite ?? 'normale') }}</td>
                        <td class="px-2 sm:px-4 py-3">@include('partials.statut-badge', ['statut' => $complaint->statut])</td>
                        <td class="px-2 sm:px-4 py-3">
                            <a href="{{ route('complaints.show', $complaint) }}" class="text-blue-600 hover:underline mr-2 text-xs">Voir</a>
                            <button onclick="openResponseModal({{ $complaint->id }})" class="text-green-600 hover:underline text-xs">Répondre</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-12 text-center text-gray-500">Aucune plainte assignée</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($complaints) && $complaints->hasPages())
        <div class="p-4 border-t">{{ $complaints->links() }}</div>
        @endif
    </div>

    @if(isset($actions) && $actions->count())
    <div class="bg-white rounded-2xl shadow-lg p-4 lg:p-6">
        <h2 class="font-bold mb-4 text-sm sm:text-base">Historique de mes actions</h2>
        <div class="space-y-3">
            @foreach($actions as $action)
            <div class="bg-gray-50 rounded-xl p-4 text-xs sm:text-sm">
                <p class="font-medium">Réponse — {{ $action->plainte?->code_suivi }}</p>
                <p class="text-gray-600 mt-1">{{ Str::limit($action->message, 100) }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $action->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<div id="responseModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-4 lg:p-6 max-w-lg w-full mx-4">
        <h3 class="font-bold text-lg mb-4">Répondre à la plainte</h3>
        <form method="POST" action="{{ route('agent.respond') }}">
            @csrf
            <input type="hidden" name="complaint_id" id="responseComplaintId">
            <select name="statut" required class="w-full border rounded-xl px-4 py-3 mb-3 text-sm">
                @foreach($statuts ?? \App\Support\PlainteStatut::all() as $s)
                <option value="{{ $s }}" @selected($s === \App\Support\PlainteStatut::EN_COURS)>{{ $s }}</option>
                @endforeach
            </select>
            <textarea name="reponse" rows="4" required class="w-full border rounded-xl px-4 py-3 mb-4 text-sm" placeholder="Votre réponse..."></textarea>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-700 text-white py-2 rounded-xl text-sm">Envoyer</button>
                <button type="button" onclick="closeResponseModal()" class="flex-1 border py-2 rounded-xl text-sm">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
function openResponseModal(id){document.getElementById('responseComplaintId').value=id;document.getElementById('responseModal').classList.replace('hidden','flex');}
function closeResponseModal(){document.getElementById('responseModal').classList.replace('flex','hidden');}
</script>
@endsection
