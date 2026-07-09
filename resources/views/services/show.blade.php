@extends('base.admin')

@section('title', 'Détails du service')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-royal-blue-700">Détails du service</h1>
            <p class="text-gray-600 mt-2">Informations sur le service</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl">
            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Nom</h2>
                <p class="text-gray-900 mt-2 text-xl">{{ $service->name ?? '-' }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-600">Description</h3>
                <p class="text-gray-800 mt-2">{{ $service->description ?? '-' }}</p>
            </div>

            <div class="flex gap-4 mt-6">
                <a href="{{ route('services.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Retour</a>
                <a href="{{ route('services.edit', $service->id ?? 0) }}" class="bg-royal-blue-600 text-white px-4 py-2 rounded-lg hover:bg-royal-blue-700 transition-colors">Modifier</a>
            </div>
        </div>
    </div>
</div>
@endsection
