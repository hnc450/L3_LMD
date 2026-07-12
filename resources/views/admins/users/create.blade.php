@extends('base.admin')

@section('title','Créer un utilisateur')

@section('content')

<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-5xl mx-auto px-4">

        <div class="flex justify-between items-center mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Ajouter un utilisateur
                </h1>

                <p class="text-gray-500 mt-2">
                    Créez un nouveau compte utilisateur.
                </p>
            </div>

            <a href="{{ route('admin.users') }}"
               class="px-5 py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800 transition">
                Retour
            </a>

        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-700 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-100 text-red-700 border border-red-300">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow">

            <div class="border-b px-8 py-5">
                <h2 class="text-xl font-semibold">
                    Informations du compte
                </h2>
            </div>

            <form action="{{ route('admin.users.store') }}"
                  method="POST"
                  class="p-8">

                @csrf

                <div class="grid md:grid-cols-2 gap-6">

                    <div>

                        <label class="block mb-2 text-sm font-medium">
                            Nom complet
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    <div>

                        <label class="block mb-2 text-sm font-medium">
                            Adresse email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    <div>

                        <label class="block mb-2 text-sm font-medium">
                            Téléphone
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    <div>

                        <label class="block mb-2 text-sm font-medium">
                            Rôle
                        </label>

                        <select
                            name="role"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">
                            <option value="">Sélectionner</option>
                            @forelse ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role')==$role->id ? 'selected':'' }}>
                                    {{ $role->name }}
                                </option>
                            @empty
                                <option value="">Aucun rôle disponible</option>
                            @endforelse
                         


                        </select>

                    </div>

                </div>

                <hr class="my-8">

                <h3 class="font-semibold text-lg mb-6">
                    Mot de passe
                </h3>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>

                        <label class="block mb-2 text-sm font-medium">
                            Mot de passe
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    </div>

                    <div>

                        <label class="block mb-2 text-sm font-medium">
                            Confirmation
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                    </div>

                </div>

                <div class="flex justify-end gap-4 mt-10">

                    <a href="{{ route('admin.users') }}"
                       class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300">

                        Annuler

                    </a>

                    <button
                        class="px-8 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700">

                        Créer le compte

                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

@endsection