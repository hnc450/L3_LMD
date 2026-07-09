@extends('base.admin')

@section('title','Gestion des services')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-royal-blue-700">Services</h1>
                <p class="text-gray-600 mt-2">Liste des services publics gérés par la plateforme</p>
            </div>
            <div>
                <a href="{{ route('services.create') }}" class="bg-royal-blue-600 text-white px-4 py-2 rounded-lg hover:bg-royal-blue-700 transition-colors">➕ Nouveau service</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($services ?? [] as $service)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-royal-blue-600">#{{ $service->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $service->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ Str::limit($service->description ?? '-', 80) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-3">
                                <a href="{{ route('services.show', $service->id) }}" class="text-royal-blue-600 hover:text-royal-blue-900 font-medium">Voir</a>
                                <a href="{{ route('services.edit', $service->id) }}" class="text-green-600 hover:text-green-900 font-medium">Modifier</a>
                                <form method="POST" action="{{ route('services.destroy', $service->id) }}" onsubmit="return confirm('Supprimer ce service ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <p class="text-lg">Aucun service trouvé</p>
                            <a href="{{ route('services.create') }}" class="text-royal-blue-600 hover:text-royal-blue-900 font-medium mt-2 inline-block">Créer un service</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
