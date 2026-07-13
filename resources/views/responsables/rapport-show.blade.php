@extends('base.user')

@section('title', 'Détail du rapport')

@section('content')
<div class="min-h-[calc(100vh-200px)] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('responsable.rapports') }}" 
               class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800">
                <i class="fa-solid fa-arrow-left"></i>
                Retour aux rapports
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-900 via-blue-700 to-blue-500 p-6 text-white">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <p class="text-blue-100 text-sm mb-2">Rapport de</p>
                        <p class="font-semibold text-lg">{{ $rapport->agent?->name ?? 'Agent' }}</p>
                        <h1 class="text-3xl font-bold mt-4">{{ $rapport->title }}</h1>
                    </div>
                    @if(!$rapport->is_read)
                        <span class="px-3 py-1 bg-white/20 rounded-full text-sm">Non lu</span>
                    @endif
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-5 mb-8">
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-gray-500 text-sm">Service</p>
                        <p class="font-semibold mt-1">{{ $rapport->service?->name ?? 'Non défini' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-gray-500 text-sm">Date d'envoi</p>
                        <p class="font-semibold mt-1">{{ $rapport->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="font-bold text-xl mb-3">Contenu du rapport</h2>
                    <div class="bg-gray-50 rounded-2xl p-5 text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $rapport->content }}
                    </div>
                </div>
                
                @if($rapport->file_attachment)
                    <div class="mb-6">
                        <h2 class="font-bold text-xl mb-3">Pièce jointe</h2>
                        <a href="#" class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-xl hover:bg-blue-700 transition">
                            <i class="fa-solid fa-paperclip"></i>
                            Télécharger la pièce jointe
                        </a>
                    </div>
                @endif
                
                @if(!$rapport->is_read)
                    <form action="{{ route('responsable.rapports.read', $rapport) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <button type="submit" class="w-full py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            Marquer comme lu
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
