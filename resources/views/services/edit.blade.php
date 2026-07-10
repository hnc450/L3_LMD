@extends('base.admin')

@section('title', 'Modifier un service')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-royal-blue-700">Modifier le service</h1>
            <p class="text-gray-600 mt-3">Mettez à jour les informations du service</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-xl p-8 max-w-2xl mx-auto border border-gray-200">
            <form method="POST" action="{{ route('services.update', $service->id ?? 0) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nom -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nom du service</label>
                    <input type="text" name="name" value="{{ old('name', $service->name ?? '') }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500 transition" />
                    @error('name') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500 transition">{{ old('description', $service->description ?? '') }}</textarea>
                    @error('description') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Photo du service</label>
                    <input type="file" name="image" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500 transition" />
                    @if(!empty($service->image))
                        <p class="mt-2 text-sm text-gray-600">Image actuelle :</p>
                        <img src="{{ asset('storage/'.$service->image) }}" alt="Service image" class="mt-2 w-32 h-32 object-cover rounded-lg shadow">
                    @endif
                    @error('image') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Responsable -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Responsable</label>
                    <select name="responsable_id" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-royal-blue-500 transition">
                        <option value="">Selectionner un responsable</option>
                        @forelse($responsables ?? [] as $responsable)
                            <option value="{{ $responsable->id }}" 
                                {{ old('responsable_id', $service->responsable_id ?? '') == $responsable->id ? 'selected' : '' }}>
                                {{ $responsable->name }}
                            </option>
                        @empty
                            <option value="">Aucun responsable disponible</option>
                        @endforelse

                        
                    </select>
                    @error('responsable_id') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-4">
                    <a href="{{ route('services.index') }}" 
                       class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-royal-blue-600 text-white py-3 rounded-lg font-semibold shadow hover:bg-royal-blue-700 transition-colors">
                        💾 Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
