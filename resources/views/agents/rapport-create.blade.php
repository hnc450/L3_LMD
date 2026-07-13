@extends('base.user')

@section('title', 'Soumettre un rapport')

@section('content')
<div class="min-h-[calc(100vh-200px)] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-royal-blue-700">Soumettre un rapport</h2>
            <p class="mt-2 text-gray-600">Envoyez un rapport à votre responsable de service</p>
        </div>
        
        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-6">
            <p class="text-sm text-gray-700">
                <strong>Service:</strong> {{ $service->name }}<br>
                <strong>Responsable:</strong> {{ $responsable?->name ?? 'Non assigné' }}
            </p>
        </div>
        
        <form class="bg-white p-8 rounded-lg shadow-lg space-y-6" method="POST" action="{{ route('agent.rapport.store') }}" enctype="multipart/form-data">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre du rapport *</label>
                    <input id="title" name="title" type="text" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="Résumé du rapport" value="{{ old('title') }}">
                </div>
                
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Contenu du rapport *</label>
                    <textarea id="content" name="content" rows="8" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        placeholder="Décrivez en détail votre rapport...">{{ old('content') }}</textarea>
                </div>
                
                <div>
                    <label for="file_attachment" class="block text-sm font-medium text-gray-700 mb-1">Pièce jointe (optionnel)</label>
                    <input id="file_attachment" name="file_attachment" type="file" 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <p class="text-xs text-gray-500 mt-1">Formats acceptés: PDF, DOC, DOCX, JPG, PNG (max 10MB)</p>
                </div>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" 
                    class="flex-1 py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-royal-blue-600 hover:bg-royal-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-blue-500 transition-colors">
                    Soumettre le rapport
                </button>
                <a href="{{ route('agent.index') }}" 
                    class="flex-1 py-3 px-4 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-blue-500 transition-colors text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
