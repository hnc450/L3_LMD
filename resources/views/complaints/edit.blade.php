@extends('base.admin')

@section('title', 'Modifier la plainte')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('complaints.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            <i class="fa-solid fa-arrow-left mr-1"></i> Retour à la liste
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Modifier la plainte {{ $plainte->code_suivi }}</h1>
    </div>

    <form method="POST" action="{{ route('complaints.update', $plainte) }}" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
            <select name="service" required class="w-full border rounded-xl px-4 py-3">
                @foreach($services as $service)
                    <option value="{{ $service->id }}" @selected(old('service', $plainte->id_service) == $service->id)>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
            <input type="text" name="title" value="{{ old('title', $plainte->title) }}" required
                   class="w-full border rounded-xl px-4 py-3">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="5" required class="w-full border rounded-xl px-4 py-3">{{ old('description', $plainte->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
            <input type="text" name="location" value="{{ old('location', $plainte->location) }}"
                   class="w-full border rounded-xl px-4 py-3">
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="statut" class="w-full border rounded-xl px-4 py-3">
                    @foreach($statuts ?? \App\Support\PlainteStatut::all() as $s)
                        <option value="{{ $s }}" @selected(old('statut', $plainte->statut) === $s)>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Priorité</label>
                <select name="priorite" class="w-full border rounded-xl px-4 py-3">
                    @foreach(['normale', 'haute', 'urgente'] as $p)
                        <option value="{{ $p }}" @selected(old('priorite', $plainte->priorite) === $p)>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pièce jointe</label>
            @if($plainte->piece_jointe)
                <p class="text-sm text-gray-500 mb-2">Fichier actuel : {{ basename($plainte->piece_jointe) }}</p>
            @endif
            <input type="file" name="piece_jointe" class="w-full border rounded-xl px-4 py-3">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-700 text-white py-3 rounded-xl font-semibold hover:bg-blue-800">
                Enregistrer
            </button>
            <a href="{{ route('complaints.index') }}" class="flex-1 text-center border py-3 rounded-xl hover:bg-gray-50">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
