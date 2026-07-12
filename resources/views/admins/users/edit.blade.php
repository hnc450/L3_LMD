@extends('base.admin')

@section('title','Modifier un utilisateur')

@section('content')

<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-6xl mx-auto px-4">

        <!-- En-tête -->
        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Modifier un utilisateur
                </h1>

                <p class="text-gray-500 mt-2">
                    Modifiez les informations du compte utilisateur.
                </p>
            </div>

            <a href="{{ route('admin.users') }}"
               class="px-5 py-3 bg-gray-700 hover:bg-gray-800 text-white rounded-xl transition">

                Retour

            </a>

        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-300 bg-green-50 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-300 bg-red-50 p-4 text-red-700">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Carte utilisateur -->
            <div class="bg-white rounded-2xl shadow overflow-hidden">

                <div class="bg-indigo-600 h-28"></div>

                <div class="-mt-14 flex justify-center">

                    <div class="w-28 h-28 rounded-full bg-white border-4 border-white shadow flex items-center justify-center text-4xl font-bold text-indigo-600">

                        {{ strtoupper(substr($user->name,0,1)) }}

                    </div>

                </div>

                <div class="p-6 text-center">

                    <h2 class="text-2xl font-semibold">
                        {{ $user->name }}
                    </h2>

                    <p class="text-gray-500 mt-2">
                        {{ $user->email }}
                    </p>

                    @if($user->phone)
                        <p class="text-gray-500">
                            {{ $user->phone }}
                        </p>
                    @endif

                    <div class="mt-6 border-t pt-5 space-y-3">

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Créé le
                            </span>

                            <span class="font-medium">
                                {{ $user->created_at->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">
                                Email vérifié
                            </span>

                            @if($user->email_verified_at)
                                <span class="text-green-600 font-semibold">
                                    Oui
                                </span>
                            @else
                                <span class="text-red-600 font-semibold">
                                    Non
                                </span>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

            <!-- Formulaire -->
            <div class="lg:col-span-2">

                <div class="bg-white rounded-2xl shadow">

                    <div class="border-b px-8 py-5">
                        <h2 class="text-xl font-semibold">
                            Informations du compte
                        </h2>
                    </div>

                    <form action="{{ route('admin.users.update',$user->id) }}"
                          method="POST"
                          class="p-8">

                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 gap-6">

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom complet
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name',$user->name) }}"
                                    required
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                            </div>

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Adresse e-mail
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email',$user->email) }}"
                                    required
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                            </div>

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Téléphone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone',$user->phone) }}"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                            </div>

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Date de création
                                </label>

                                <input
                                    type="text"
                                    disabled
                                    value="{{ $user->created_at->format('d/m/Y H:i') }}"
                                    class="w-full rounded-xl border bg-gray-100 px-4 py-3">

                            </div>

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Rôle
                                </label>

                                <select name="role_id" class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">
                         

                                @forelse($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @empty
                                    <option value="">Aucun rôle trouvé</option>
                                @endforelse
                                </select>
                            </div>

                        </div>

                        <hr class="my-8">

                        <h3 class="font-semibold text-lg mb-6">
                            Modifier le mot de passe
                        </h3>

                        <div class="grid md:grid-cols-2 gap-6">

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nouveau mot de passe
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                            </div>

                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmer le mot de passe
                                </label>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500">

                            </div>

                        </div>

                        <p class="text-sm text-gray-500 mt-4">
                            Laissez les champs du mot de passe vides si vous ne souhaitez pas le modifier.
                        </p>

                        <div class="flex justify-end gap-4 mt-10">

                            <a href="{{ route('admin.users') }}"
                               class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 transition">

                                Annuler

                            </a>

                            <button
                                type="submit"
                                class="px-8 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium transition">

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