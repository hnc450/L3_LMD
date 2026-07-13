@extends('base.user')

@section('title', 'Rapports reçus')

@section('content')
<div class="min-h-[calc(100vh-200px)] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-royal-blue-700">Rapports reçus</h2>
                <p class="mt-2 text-gray-600">Consultez les rapports de vos agents</p>
            </div>
            @if($unreadCount > 0)
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">
                    {{ $unreadCount }} non lu(s)
                </div>
            @endif
        </div>
        
        @if($rapports->count() > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($rapports as $rapport)
                                <tr class="{{ $rapport->is_read ? '' : 'bg-blue-50' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if(!$rapport->is_read)
                                                <span class="h-2 w-2 bg-blue-600 rounded-full mr-2"></span>
                                            @endif
                                            <div class="text-sm font-medium text-gray-900">{{ $rapport->title }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $rapport->agent?->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $rapport->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($rapport->is_read)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lu</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Non lu</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('responsable.rapports.show', $rapport) }}" class="text-royal-blue-600 hover:text-royal-blue-900 mr-3">Voir</a>
                                        @if(!$rapport->is_read)
                                            <form action="{{ route('responsable.rapports.read', $rapport) }}" method="POST" class="inline">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900">Marquer lu</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $rapports->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-lg p-12 text-center text-gray-500">
                <i class="fa-solid fa-file-lines text-4xl mb-4"></i>
                <p>Aucun rapport reçu pour le moment.</p>
            </div>
        @endif
    </div>
</div>
@endsection
