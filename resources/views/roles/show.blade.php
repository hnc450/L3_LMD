@extends('base.admin')

@section('title', 'Détails du rôle')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="container mx-auto px-6">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-royal-blue-700">Détails du rôle</h1>
            <p class="text-gray-600 mt-3">Informations et métadonnées du rôle</p>
        </div>

        <div class="bg-white rounded-xl shadow-xl p-8 max-w-2xl mx-auto border border-gray-200">
            <!-- Nom du rôle -->
            <div class="mb-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Nom du rôle</h2>
                <p class="text-gray-900 mt-2 text-2xl font-bold">{{ $role->name ?? '-' }}</p>
            </div>

            <!-- Métadonnées -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                    <h3 class="text-xs font-medium text-gray-500 uppercase">ID</h3>
                    <p class="text-gray-800 text-lg font-semibold">{{ $role->id ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                    <h3 class="text-xs font-medium text-gray-500 uppercase">Créé le</h3>
                    <p class="text-gray-800 text-lg font-semibold">
                        {{ $role->created_at ? $role->created_at->format('d/m/Y H:i') : '-' }}
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 mt-8">
                <a href="{{ route('roles.index') }}" 
                   class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                    Retour
                </a>
                <a href="{{ route('roles.edit', $role->id ?? 0) }}" 
                   class="flex-1 text-center bg-royal-blue-600 text-white py-3 rounded-lg font-semibold shadow hover:bg-royal-blue-700 transition-colors">
                    Modifier
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
