@extends('base.responsable')

@section('title','Ajouter un agent')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('responsable.agents') }}" class="text-indigo-600 text-sm hover:underline"><i class="fa-solid fa-arrow-left mr-1"></i> Retour aux agents</a>
    <h1 class="text-2xl font-bold mt-4 mb-2">Nouvel agent</h1>
    <p class="text-gray-500 mb-6">L'agent sera automatiquement rattaché au service <strong>{{ $service->name }}</strong></p>

    <form method="POST" action="{{ route('responsable.agents.store') }}" class="bg-white rounded-2xl shadow-lg p-8 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nom complet</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input type="password" name="password" required class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required class="w-full border rounded-xl px-4 py-3">
        </div>
        <button type="submit" class="w-full bg-indigo-700 text-white py-3 rounded-xl font-semibold hover:bg-indigo-800">
            <i class="fa-solid fa-user-plus mr-2"></i>Créer l'agent
        </button>
    </form>
</div>
@endsection
