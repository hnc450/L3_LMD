@extends('base.admin')

@section('title','Créer un service')

@section('content')

<div class="min-h-screen bg-gray-50">

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-blue-700 to-cyan-500">

        <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-cyan-300/10 blur-3xl"></div>

        <div class="container mx-auto px-6 py-14 relative">

            <div class="text-center text-white">

                <span class="inline-flex items-center px-5 py-2 rounded-full bg-white/20">

                    <i class="fa-solid fa-building mr-2"></i>

                    Administration

                </span>

                <h1 class="text-5xl font-bold mt-5">

                    Créer un service

                </h1>

                <p class="text-blue-100 mt-4 text-lg">

                    Ajoutez un nouveau service public à la plateforme.

                </p>

            </div>

        </div>

    </section>

    <div class="container mx-auto px-6 -mt-10 relative z-10">

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- FORMULAIRE -->

            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                    <div class="border-b px-8 py-6">

                        <h2 class="text-2xl font-bold text-gray-800">

                            Informations du service

                        </h2>

                        <p class="text-gray-500 mt-2">

                            Complétez les informations ci-dessous.

                        </p>

                    </div>

                    <form method="POST"
                          action="{{ route('services.store') }}"
                          enctype="multipart/form-data"
                          class="p-8 space-y-8">

                        @csrf

                        <!-- Nom -->

                        <div>

                            <label class="block font-semibold text-gray-700 mb-3">

                                Nom du service

                            </label>

                            <div class="relative">

                                <i class="fa-solid fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Ex : Voirie"
                                    required
                                    class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-600 outline-none">

                            </div>

                            @error('name')

                            <p class="text-red-600 text-sm mt-2">

                                {{ $message }}

                            </p>

                            @enderror

                        </div>

                        <!-- Description -->

                        <div>

                            <label class="block font-semibold text-gray-700 mb-3">

                                Description

                            </label>

                            <div class="relative">

                                <i class="fa-solid fa-align-left absolute left-4 top-5 text-gray-400"></i>

                                <textarea
                                    name="description"
                                    rows="5"
                                    placeholder="Décrivez le service..."
                                    class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-600 outline-none">{{ old('description') }}</textarea>

                            </div>

                            @error('description')

                            <p class="text-red-600 text-sm mt-2">

                                {{ $message }}

                            </p>

                            @enderror

                        </div>

                        <!-- Responsable -->

                        <div>

                            <label class="block font-semibold text-gray-700 mb-3">

                                Responsable

                            </label>

                            <div class="relative">

                                <i class="fa-solid fa-user-tie absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                                <select
                                    name="responsable_id"
                                    class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-600 outline-none">

                                    <option value="">

                                        Sélectionner un responsable

                                    </option>

                                    @foreach($responsables ?? [] as $responsable)

                                        <option
                                            value="{{ $responsable->id }}"
                                            {{ old('responsable_id') == $responsable->id ? 'selected' : '' }}>

                                            {{ $responsable->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            @error('responsable_id')

                            <p class="text-red-600 text-sm mt-2">

                                {{ $message }}

                            </p>

                            @enderror

                        </div>

                        <!-- Image -->

                        <div>

                            <label class="block font-semibold text-gray-700 mb-3">

                                Image du service

                            </label>

                            <label
                                class="border-2 border-dashed border-blue-300 rounded-2xl p-10 flex flex-col items-center justify-center cursor-pointer hover:border-blue-600 transition">

                                <i class="fa-solid fa-cloud-arrow-up text-5xl text-blue-600 mb-4"></i>

                                <span class="font-semibold">

                                    Cliquez pour choisir une image

                                </span>

                                <span class="text-sm text-gray-500 mt-2">

                                    PNG, JPG ou JPEG

                                </span>

                                <input
                                    type="file"
                                    name="image"
                                    accept="image/*"
                                    class="hidden">

                            </label>

                            @error('image')

                            <p class="text-red-600 text-sm mt-2">

                                {{ $message }}

                            </p>

                            @enderror

                        </div>

                        <!-- Boutons -->

                        <div class="flex flex-col sm:flex-row gap-4">

                            <a href="{{ route('services.index') }}"
                               class="flex-1 flex justify-center items-center gap-3 py-4 rounded-2xl bg-gray-100 hover:bg-gray-200 font-semibold transition">

                                <i class="fa-solid fa-arrow-left"></i>

                                Retour

                            </a>

                            <button
                                class="flex-1 flex justify-center items-center gap-3 py-4 rounded-2xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold shadow-lg hover:scale-105 transition">

                                <i class="fa-solid fa-plus"></i>

                                Créer le service

                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <!-- SIDEBAR -->

            <div>

                <div class="bg-white rounded-3xl shadow-xl p-8">

                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">

                        <i class="fa-solid fa-circle-info text-blue-700 text-2xl"></i>

                    </div>

                    <h3 class="text-xl font-bold">

                        Conseils

                    </h3>

                    <ul class="space-y-5 mt-6 text-gray-600">

                        <li class="flex gap-3">

                            <i class="fa-solid fa-check text-green-500 mt-1"></i>

                            Choisissez un nom explicite.

                        </li>

                        <li class="flex gap-3">

                            <i class="fa-solid fa-check text-green-500 mt-1"></i>

                            Ajoutez une description claire.

                        </li>

                        <li class="flex gap-3">

                            <i class="fa-solid fa-check text-green-500 mt-1"></i>

                            Affectez un responsable.

                        </li>

                        <li class="flex gap-3">

                            <i class="fa-solid fa-check text-green-500 mt-1"></i>

                            Téléversez un logo représentatif.

                        </li>

                    </ul>

                </div>

                <div class="mt-6 rounded-3xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white p-8 shadow-xl">

                    <i class="fa-solid fa-shield-halved text-3xl mb-5"></i>

                    <h3 class="text-2xl font-bold">

                        Gestion

                    </h3>

                    <p class="mt-4 text-blue-100 leading-7">

                        Chaque service peut être associé à un responsable qui sera chargé du traitement des plaintes des citoyens.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection