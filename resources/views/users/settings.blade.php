@extends('base.user')

@section('title', 'Paramètres du compte')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-5xl mx-auto px-4">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Paramètres du compte
            </h1>
            <p class="text-gray-500 mt-2">
                Gérez votre adresse e-mail ainsi que votre mot de passe.
            </p>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-700 px-5 py-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-700 px-5 py-4">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">

            <!-- Profil -->
            <div class="bg-white rounded-2xl shadow p-6">

                <div class="flex justify-center">
                    <div class="w-24 h-24 rounded-full bg-indigo-600 text-white flex items-center justify-center text-4xl font-bold">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>
                </div>

                <div class="text-center mt-5">
                    <h2 class="font-semibold text-xl">
                        {{ auth()->user()->name }}
                    </h2>

                    <p class="text-gray-500 mt-1">
                        {{ auth()->user()->email }}
                    </p>

                    <span class="inline-block mt-4 px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                        Compte actif
                    </span>
                </div>

            </div>

            <div class="lg:col-span-2 space-y-6">

                <!-- Modifier Email -->
                <div class="bg-white rounded-2xl shadow">

                    <div class="border-b px-6 py-4">
                        <h2 class="font-semibold text-lg">
                            Modifier l'adresse e-mail
                        </h2>
                    </div>

                    <form action="{{ route('user.settings.email') }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Adresse e-mail actuelle
                            </label>

                            <input
                                type="email"
                                value="{{ auth()->user()->email }}"
                                disabled
                                class="w-full rounded-lg border bg-gray-100 px-4 py-3"
                            >
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nouvelle adresse e-mail
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 px-4 py-3"
                            >
                        </div>

                        <button
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition">
                            Mettre à jour l'e-mail
                        </button>

                    </form>

                </div>

                <!-- Modifier mot de passe -->
                <div class="bg-white rounded-2xl shadow">

                    <div class="border-b px-6 py-4">
                        <h2 class="font-semibold text-lg">
                            Modifier le mot de passe
                        </h2>
                    </div>

                    <form action="{{ route('user.settings.password') }}" method="POST" class="p-6">

                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mot de passe actuel
                            </label>

                            <input
                                type="password"
                                name="current_password"
                                required
                                class="w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 px-4 py-3">
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nouveau mot de passe
                            </label>

                            <input
                                type="password"
                                name="password"
                                required
                                class="w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 px-4 py-3">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmer le nouveau mot de passe
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                class="w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 px-4 py-3">
                        </div>

                        <button
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition">
                            Modifier le mot de passe
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection