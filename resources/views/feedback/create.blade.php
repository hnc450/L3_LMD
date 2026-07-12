@extends('base.user')

@section('title', 'Feedback')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-2">Donner votre feedback</h1>
    <p class="text-gray-500 mb-6">Évaluez la qualité de la réponse à votre plainte</p>

    @if(isset($plainte))
    <div class="bg-white rounded-2xl shadow p-5 mb-6">
        <p class="font-mono text-sm text-blue-700">{{ $plainte->code_suivi }}</p>
        <p class="font-semibold mt-1">{{ $plainte->title }}</p>
    </div>

    <form method="POST" action="{{ route('feedback.store') }}" class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
        @csrf
        <input type="hidden" name="complaint_id" value="{{ $plainte->id }}">

        <div>
            <label class="block text-sm font-medium mb-3">Note (1 à 5)</label>
            <div class="flex justify-center gap-3">
                @for($i = 1; $i <= 5; $i++)
                <label class="cursor-pointer">
                    <input type="radio" name="note" value="{{ $i }}" class="hidden peer" required>
                    <div class="w-12 h-12 rounded-full bg-gray-100 peer-checked:bg-blue-700 peer-checked:text-white flex items-center justify-center font-bold hover:bg-blue-200 transition">{{ $i }}</div>
                </label>
                @endfor
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Commentaire (optionnel)</label>
            <textarea name="commentaire" rows="4" class="w-full border rounded-xl px-4 py-3" placeholder="Partagez votre expérience...">{{ old('commentaire') }}</textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-700 text-white py-3 rounded-xl font-semibold">Envoyer</button>
            <a href="{{ route('complaints.show', $plainte) }}" class="flex-1 text-center border py-3 rounded-xl">Annuler</a>
        </div>
    </form>
    @endif
</div>
@endsection
