@extends('base.user')

@section('title', 'Feedback - Plateforme de Plaintes')

@section('content')
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-royal-blue-700">Donner votre feedback</h2>
            <p class="mt-2 text-gray-600">Évaluez la qualité de la réponse à votre plainte</p>
        </div>
        
        @if(isset($complaint))
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h3 class="font-semibold text-gray-900 mb-2">Plainte #{{ $complaint->id }}</h3>
            <p class="text-gray-700">{{ $complaint->titre }}</p>
        </div>
        @endif
        
        <form class="bg-white p-8 rounded-lg shadow-lg space-y-6" method="POST" action="{{ route('feedback.store') }}">
            @csrf
            <input type="hidden" name="complaint_id" value="{{ $complaint->id ?? '' }}">
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">Note de satisfaction (1-5)</label>
                <div class="flex items-center justify-center gap-4">
                    @for($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="note" value="{{ $i }}" class="hidden peer" required>
                        <div class="w-12 h-12 rounded-full bg-gray-200 peer-checked:bg-royal-blue-600 flex items-center justify-center text-2xl transition-colors hover:bg-royal-blue-400">
                            {{ $i }}
                        </div>
                    </label>
                    @endfor
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>1 - Très insatisfait</span>
                    <span>5 - Très satisfait</span>
                </div>
            </div>
            
            <div>
                <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-1">Commentaire (optionnel)</label>
                <textarea id="commentaire" name="commentaire" rows="4" 
                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-royal-blue-500 focus:border-royal-blue-500"
                    placeholder="Partagez votre expérience ou suggestions d'amélioration...">{{ old('commentaire') }}</textarea>
            </div>
            
            <div class="bg-royal-blue-50 p-4 rounded-lg">
                <h4 class="font-medium text-royal-blue-700 mb-2">Questions supplémentaires (optionnel)</h4>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input type="checkbox" name="reponse_rapide" id="reponse_rapide" class="h-4 w-4 text-royal-blue-600 focus:ring-royal-blue-500 border-gray-300 rounded">
                        <label for="reponse_rapide" class="ml-2 text-sm text-gray-700">La réponse a été rapide</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="reponse_claire" id="reponse_claire" class="h-4 w-4 text-royal-blue-600 focus:ring-royal-blue-500 border-gray-300 rounded">
                        <label for="reponse_claire" class="ml-2 text-sm text-gray-700">La réponse était claire et utile</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="probleme_resolu" id="probleme_resolu" class="h-4 w-4 text-royal-blue-600 focus:ring-royal-blue-500 border-gray-300 rounded">
                        <label for="probleme_resolu" class="ml-2 text-sm text-gray-700">Le problème a été résolu</label>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" 
                    class="flex-1 py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-royal-blue-600 hover:bg-royal-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-blue-500 transition-colors">
                    Envoyer le feedback
                </button>
                <a href="{{ route('complaint.show', $complaint->id ?? '') }}" 
                    class="flex-1 py-3 px-4 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-blue-500 transition-colors text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
