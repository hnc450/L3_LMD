@extends('base.user')

@section('title','Mon profil')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Titre -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Mon profil
            </h1>

            <p class="text-gray-500 mt-2">
                Consultez et modifiez vos informations personnelles.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Carte Profil -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

                <div class="bg-indigo-600 h-28"></div>

                <div class="-mt-14 flex justify-center">

                    <div
                        class="w-28 h-28 rounded-full bg-white border-4 border-white shadow flex items-center justify-center text-4xl font-bold text-indigo-600">

                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                    </div>

                </div>

                <div class="p-6 text-center">

                    <h2 class="text-2xl font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </h2>

                    <p class="text-gray-500 mt-1">
                        {{ auth()->user()->email }}
                    </p>

                    @if(auth()->user()->phone)
                        <p class="text-gray-500 mt-1">
                            {{ auth()->user()->phone }}
                        </p>
                    @endif

                    <div class="mt-6 border-t pt-5">

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500">
                                Compte créé
                            </span>

                            <span class="font-medium">
                                {{ auth()->user()->created_at->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between py-2">
                            <span class="text-gray-500">
                                Email vérifié
                            </span>

                            @if(auth()->user()->email_verified_at)
                                <span class="text-green-600 font-medium">
                                    Oui
                                </span>
                            @else
                                <span class="text-red-600 font-medium">
                                    Non
                                </span>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

            <!-- Formulaire -->
            <div class="lg:col-span-2">

                <div class="bg-white rounded-2xl shadow-lg">

                    <div class="border-b px-8 py-5">

                        <h2 class="text-xl font-semibold">
                            Informations personnelles
                        </h2>

                    </div>

                    <form
                        action="{{ route('user.profile.update') }}"
                        method="POST"
                        class="p-8">

                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 gap-6">

                            <!-- Nom -->

                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Nom complet
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name',auth()->user()->name) }}"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                    required>

                            </div>

                            <!-- Téléphone -->

                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Numéro de téléphone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone',auth()->user()->phone) }}"
                                    placeholder="+243..."
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring focus:ring-indigo-200">

                            </div>

                        </div>

                        <!-- Email -->

                        <div class="mt-6">

                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Adresse e-mail
                            </label>

                            <input
                                type="email"
                                value="{{ auth()->user()->email }}"
                                disabled
                                class="w-full rounded-xl bg-gray-100 border border-gray-300 px-4 py-3 cursor-not-allowed">

                            <p class="text-gray-500 text-sm mt-2">
                                L'adresse e-mail se modifie depuis la page
                                <strong>Paramètres</strong>.
                            </p>

                        </div>

                        <div class="mt-8 flex justify-end">

                            <button
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-medium transition">

                                Enregistrer les modifications

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection