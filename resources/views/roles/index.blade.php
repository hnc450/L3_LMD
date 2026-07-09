@extends('base.admin')
@section('title','Administration des rôles')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-extrabold text-royal-blue-700">Gestion des rôles</h1>
                <p class="text-gray-600 mt-3">Créez, modifiez et supprimez les rôles du système</p>
            </div>
            <div>
                <a href="{{ route('roles.create') }}" 
                   class="inline-flex items-center gap-2 bg-royal-blue-600 text-white px-5 py-3 rounded-lg font-semibold shadow hover:bg-royal-blue-700 transition-colors">
                    <span class="text-lg">➕</span> Nouveau rôle
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Créé le</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($roles ?? [] as $role)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-royal-blue-600">#{{ $role->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $role->created_at ? $role->created_at->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-4">
                                <a href="{{ route('roles.show', $role->id) }}" 
                                   class="inline-flex items-center gap-1 text-royal-blue-600 hover:text-royal-blue-900 font-medium">
                                    👁️ Voir
                                </a>
                                <a href="{{ route('roles.edit', $role->id) }}" 
                                   class="inline-flex items-center gap-1 text-green-600 hover:text-green-900 font-medium">
                                    ✏️ Modifier
                                </a>
                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}" 
                                      onsubmit="return confirm('Supprimer ce rôle ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1 text-red-600 hover:text-red-900 font-medium">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <p class="text-lg font-medium">Aucun rôle trouvé</p>
                            <a href="{{ route('roles.create') }}" 
                               class="mt-3 inline-block text-royal-blue-600 hover:text-royal-blue-900 font-semibold">
                                ➕ Créer un rôle
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($roles) && method_exists($roles, 'links'))
        <div class="p-6">
            {{ $roles->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
