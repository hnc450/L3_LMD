@extends('base.admin')

@section('title', 'Modifier un service')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-royal-blue-700">Modifier le service</h1>
            <p class="text-gray-600 mt-2">Mettez à jour les informations du service</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl">
            <form method="POST" action="{{ route('services.update', $service->id ?? 0) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" name="name" value="{{ old('name', $service->name ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500" />
                    @error('name') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500">{{ old('description', $service->description ?? '') }}</textarea>
                    @error('description') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('services.index') }}" class="flex-1 text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition-colors">Annuler</a>
                    <button type="submit" class="flex-1 bg-royal-blue-600 text-white py-2 rounded-lg hover:bg-royal-blue-700 transition-colors">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
