@extends('base.base')

@section('title', 'Vérification de l\'email')

@section('content')
<div class="min-h-[calc(100vh-200px)] py-12 px-6">
    <div class="max-w-md mx-auto">
        <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-envelope text-blue-600 text-2xl"></i>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Vérifiez votre email</h2>
            
            <p class="text-gray-600 mb-6">
                Un lien de vérification a été envoyé à votre adresse email. 
                Veuillez cliquer sur ce lien pour activer votre compte.
            </p>
            
            <p class="text-sm text-gray-500 mb-6">
                Si vous n'avez pas reçu l'email, vérifiez votre dossier spam ou demandez un nouveau lien.
            </p>
            
            @if(session('resent'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                    Un nouveau lien de vérification a été envoyé.
                </div>
            @endif
            
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                    Renvoyer le lien de vérification
                </button>
            </form>
            
            <div class="mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('auth.logout') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                    Déconnexion
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
