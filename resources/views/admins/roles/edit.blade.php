@extends('base.admin')

@section('title', 'Modifier un rôle')

@section('content')

<div class="min-h-screen bg-gray-50">

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-blue-700 to-cyan-500">

        <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 py-14 relative">

            <div class="text-center text-white">

                <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/20">

                    <i class="fa-solid fa-user-gear mr-2"></i>

                    Administration

                </span>

                <h1 class="text-5xl font-bold mt-5">

                    Modifier un rôle

                </h1>

                <p class="text-blue-100 mt-4 text-lg">

                    Modifiez les informations du rôle sélectionné.

                </p>

            </div>

        </div>

    </section>

    <div class="container mx-auto px-6 -mt-10 relative z-10">

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Formulaire -->

            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                    <div class="border-b px-8 py-6">

                        <h2 class="text-2xl font-bold text-gray-800">

                            Informations du rôle

                        </h2>

                        <p class="text-gray-500 mt-2">

                            Mettez à jour le nom du rôle.

                        </p>

                    </div>

                    <form method="POST"
                          action="{{ route('admin.roles.update', $role->id) }}"
                          class="p-8 space-y-8">

                        @csrf
                        @method('PUT')

                        <!-- ID -->

                        <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5">

                            <div class="flex items-center gap-3">

                                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">

                                    <i class="fa-solid fa-hashtag text-blue-700"></i>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">

                                        Identifiant

                                    </p>

                                    <h3 class="text-xl font-bold text-blue-700">

                                        #{{ $role->id }}

                                    </h3>

                                </div>

                            </div>

                        </div>

                        <!-- Nom -->

                        <div>

                            <label class="block font-semibold text-gray-700 mb-3">

                                Nom du rôle

                            </label>

                            <div class="relative">

                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">

                                    <i class="fa-solid fa-user-tag"></i>

                                </span>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $role->name) }}"
                                    placeholder="Ex : Super Administrateur"
                                    required
                                    class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-300 focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none transition">

                            </div>

                            @error('name')

                            <div class="flex items-center mt-3 text-red-600 text-sm">

                                <i class="fa-solid fa-circle-exclamation mr-2"></i>

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                        <!-- Boutons -->

                        <div class="flex flex-col sm:flex-row gap-4">

                            <a href="{{ route('admin.roles.index') }}"
                               class="flex-1 flex justify-center items-center gap-3 py-4 rounded-2xl bg-gray-100 hover:bg-gray-200 transition font-semibold text-gray-700">

                                <i class="fa-solid fa-arrow-left"></i>

                                Retour

                            </a>

                            <button
                                type="submit"
                                class="flex-1 flex justify-center items-center gap-3 py-4 rounded-2xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold shadow-lg hover:scale-105 transition">

                                <i class="fa-solid fa-floppy-disk"></i>

                                Enregistrer

                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <!-- Informations -->

            <div>

                <div class="bg-white rounded-3xl shadow-xl p-8">

                    <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center mb-6">

                        <i class="fa-solid fa-lightbulb text-yellow-600 text-2xl"></i>

                    </div>

                    <h3 class="text-xl font-bold">

                        Bonnes pratiques

                    </h3>

                    <ul class="mt-6 space-y-5 text-gray-600">

                        <li class="flex gap-3">

                            <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>

                            Choisissez un nom clair et explicite.

                        </li>

                        <li class="flex gap-3">

                            <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>

                            Évitez les noms identiques.

                        </li>

                        <li class="flex gap-3">

                            <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>

                            Vérifiez les permissions associées après modification.

                        </li>

                    </ul>

                </div>

                <div class="mt-6 rounded-3xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white p-8 shadow-xl">

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center mb-5">

                        <i class="fa-solid fa-shield-halved text-2xl"></i>

                    </div>

                    <h3 class="text-2xl font-bold">

                        Sécurité

                    </h3>

                    <p class="mt-4 text-blue-100 leading-7">

                        Toute modification d'un rôle peut avoir un impact sur les
                        autorisations des utilisateurs. Vérifiez les changements
                        avant de les enregistrer.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection