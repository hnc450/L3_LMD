@extends('base.admin')

@section('title', 'Détails de l\'utilisateur')

@section('content')

<div class="min-h-screen bg-gray-50">

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-blue-700 to-cyan-500">

        <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-cyan-300/10 blur-3xl"></div>

        <div class="container mx-auto px-6 py-14 relative">

            <div class="flex flex-col lg:flex-row items-center justify-between">

                <div class="flex items-center gap-6">

                    <div class="w-28 h-28 rounded-full bg-white/20 border-4 border-white flex items-center justify-center">

                        <i class="fa-solid fa-user text-5xl text-white"></i>

                    </div>

                    <div class="text-white">

                        <h1 class="text-4xl font-bold">

                            {{ $user->name }}

                        </h1>

                        <p class="text-blue-100 mt-2">

                            {{ $user->email }}

                        </p>

                    </div>

                </div>

                <div class="mt-8 lg:mt-0">

                    <span class="px-5 py-3 rounded-full bg-white/20">

                        <i class="fa-solid fa-user-shield mr-2"></i>

                        {{ $user->role->name ?? 'Aucun rôle' }}

                    </span>

                </div>

            </div>

        </div>

    </section>

    <div class="container mx-auto px-6 -mt-10 relative z-10">

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Informations -->

            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                    <div class="border-b px-8 py-6">

                        <h2 class="text-2xl font-bold">

                            Informations générales

                        </h2>

                        <p class="text-gray-500 mt-2">

                            Informations concernant cet utilisateur.

                        </p>

                    </div>

                    <div class="grid md:grid-cols-2 gap-6 p-8">

                        <div class="bg-gray-50 rounded-2xl p-6">

                            <p class="text-gray-500 text-sm">

                                Nom

                            </p>

                            <h3 class="text-xl font-bold mt-2">

                                {{ $user->name }}

                            </h3>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-6">

                            <p class="text-gray-500 text-sm">

                                Email

                            </p>

                            <h3 class="text-lg font-semibold mt-2">

                                {{ $user->email }}

                            </h3>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-6">

                            <p class="text-gray-500 text-sm">

                                Rôle

                            </p>

                            <span class="inline-flex mt-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700">

                                {{ $user->role->name ?? '-' }}

                            </span>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-6">

                            <p class="text-gray-500 text-sm">

                                Service

                            </p>

                            <span class="inline-flex mt-2 px-4 py-2 rounded-full bg-green-100 text-green-700">

                                {{ $user->service->name ?? 'Non affecté' }}

                            </span>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-6">

                            <p class="text-gray-500 text-sm">

                                Inscription

                            </p>

                            <h3 class="font-semibold mt-2">

                                {{ $user->created_at->format('d/m/Y H:i') }}

                            </h3>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-6">

                            <p class="text-gray-500 text-sm">

                                Dernière modification

                            </p>

                            <h3 class="font-semibold mt-2">

                                {{ $user->updated_at->format('d/m/Y H:i') }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Sidebar -->

            <div>

                <div class="bg-white rounded-3xl shadow-xl p-8">

                    <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center mb-6">

                        <i class="fa-solid fa-circle-info text-blue-700 text-2xl"></i>

                    </div>

                    <h3 class="text-xl font-bold">

                        Actions

                    </h3>

                    <div class="mt-6 space-y-4">

                        <a href="{{ route('users.edit',$user->id) }}"
                           class="flex items-center justify-center gap-3 py-4 rounded-2xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold hover:scale-105 transition">

                            <i class="fa-solid fa-pen"></i>

                            Modifier

                        </a>

                        <form action="{{ route('users.destroy',$user->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Supprimer cet utilisateur ?')"
                                class="w-full flex items-center justify-center gap-3 py-4 rounded-2xl bg-red-600 hover:bg-red-700 text-white font-semibold transition">

                                <i class="fa-solid fa-trash"></i>

                                Supprimer

                            </button>

                        </form>

                        <a href="{{ route('admin.users') }}"
                           class="flex items-center justify-center gap-3 py-4 rounded-2xl bg-gray-100 hover:bg-gray-200 font-semibold">

                            <i class="fa-solid fa-arrow-left"></i>

                            Retour à la liste

                        </a>

                    </div>

                </div>

                <div class="mt-6 bg-gradient-to-r from-blue-700 to-cyan-500 rounded-3xl p-8 text-white shadow-xl">

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center mb-5">

                        <i class="fa-solid fa-shield-halved text-2xl"></i>

                    </div>

                    <h3 class="text-2xl font-bold">

                        Administration

                    </h3>

                    <p class="mt-4 text-blue-100 leading-7">

                        Cette fiche permet de consulter les informations détaillées de l'utilisateur ainsi que de gérer son compte depuis l'administration.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection