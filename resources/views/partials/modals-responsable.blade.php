@php use App\Support\PlainteStatut; @endphp

<div id="assignModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="font-bold text-lg mb-4"><i class="fa-solid fa-user-plus mr-2 text-indigo-600"></i>Affecter à un agent</h3>
        <form method="POST" action="{{ route('responsable.assign') }}">
            @csrf
            <input type="hidden" name="complaint_id" id="assignComplaintId">
            <select name="agent_id" required class="w-full border rounded-xl px-4 py-3 mb-4">
                <option value="">Sélectionnez un agent de votre service</option>
                @foreach($agents ?? [] as $agent)
                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                @endforeach
            </select>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-700 text-white py-2 rounded-xl">Affecter</button>
                <button type="button" onclick="closeAssignModal()" class="flex-1 border py-2 rounded-xl">Annuler</button>
            </div>
        </form>
    </div>
</div>

<div id="statusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="font-bold text-lg mb-4"><i class="fa-solid fa-arrows-rotate mr-2 text-indigo-600"></i>Mettre à jour le statut</h3>
        <form method="POST" action="{{ route('responsable.update-status') }}">
            @csrf
            <input type="hidden" name="complaint_id" id="statusComplaintId">
            <select name="statut" id="statusSelect" required class="w-full border rounded-xl px-4 py-3 mb-3">
                @foreach(PlainteStatut::all() as $s)
                <option value="{{ $s }}">{{ $s }}</option>
                @endforeach
            </select>
            <select name="priorite" id="prioriteSelect" class="w-full border rounded-xl px-4 py-3 mb-3">
                @foreach(['normale','haute','urgente'] as $p)
                <option value="{{ $p }}">{{ ucfirst($p) }}</option>
                @endforeach
            </select>
            <textarea name="reponse" rows="3" class="w-full border rounded-xl px-4 py-3 mb-4" placeholder="Réponse optionnelle..."></textarea>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-700 text-white py-2 rounded-xl">Enregistrer</button>
                <button type="button" onclick="closeStatusModal()" class="flex-1 border py-2 rounded-xl">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAssignModal(id){document.getElementById('assignComplaintId').value=id;document.getElementById('assignModal').classList.replace('hidden','flex');}
function closeAssignModal(){document.getElementById('assignModal').classList.replace('flex','hidden');}
function openStatusModal(id,statut,priorite){
    document.getElementById('statusComplaintId').value=id;
    document.getElementById('statusSelect').value=statut;
    document.getElementById('prioriteSelect').value=priorite||'normale';
    document.getElementById('statusModal').classList.replace('hidden','flex');
}
function closeStatusModal(){document.getElementById('statusModal').classList.replace('flex','hidden');}
</script>
