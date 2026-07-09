@extends('base.admin')

@section('title','Détails du rôle')

@section('content')

<div class="min-h-screen bg-gray-50">

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-blue-700 to-cyan-500">

        <div class="absolute -top-24 -left-24 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 py-14 relative">

            <div class="text-center text-white">

                <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/20">

                    <i class="fa-solid fa-user-shield mr-2"></i>

                    Administration

                </span>

                <h1 class="text-5xl font-bold mt-5">

                    Détails du rôle

                </h1>

                <p class="text-blue-100 mt-4 text-lg">

                    Consultez toutes les informations relatives à ce rôle.

                </p>

            </div>

        </div>

    </section>

    <div class="container mx-auto px-6 -mt-10 relative z-10">

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Informations -->

            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                    <div class="border-b px-8 py-6">

                        <h2 class="text-2xl font-bold text-gray-800">

                            Informations générales

                        </h2>

                        <p class="text-gray-500 mt-2">

                            Détails du rôle sélectionné.

                        </p>

                    </div>

                    <div class="p-8">

                        <!-- Nom -->

                        <div class="flex items-center gap-5">

                            <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center">

                                <i class="fa-solid fa-user-tag text-blue-700 text-2xl"></i>

                            </div>

                            <div>

                                <p class="text-sm text-gray-500">

                                    Nom du rôle

                                </p>

                                <h2 class="text-3xl font-bold text-gray-800">

                                    {{ $role->name ?? '-' }}

                                </h2>

                            </div>

                        </div>

                        <!-- Métadonnées -->

                        <div class="grid md:grid-cols-2 gap-6 mt-10">

                            <div class="rounded-2xl bg-gray-50 border p-6">

                                <div class="flex items-center gap-3">

                                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">

                                        <i class="fa-solid fa-hashtag text-blue-700"></i>

                                    </div>

                                    <div>

                                        <p class="text-sm text-gray-500">

                                            Identifiant

                                        </p>

                                        <h3 class="text-xl font-bold">

                                            #{{ $role->id }}

                                        </h3>

                                    </div>

                                </div>

                            </div>

                            <div class="rounded-2xl bg-gray-50 border p-6">

                                <div class="flex items-center gap-3">

                                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">

                                        <i class="fa-solid fa-calendar-days text-green-600"></i>

                                    </div>

                                    <div>

                                        <p class="text-sm text-gray-500">

                                            Créé le

                                        </p>

                                        <h3 class="text-lg font-bold">

                                            {{ $role->created_at ? $role->created_at->format('d/m/Y H:i') : '-' }}

                                        </h3>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Actions -->

                        <div class="flex flex-col sm:flex-row gap-4 mt-10">

                            <a href="{{ route('roles.index') }}"
                               class="flex-1 flex justify-center items-center gap-3 py-4 rounded-2xl bg-gray-100 hover:bg-gray-200 transition font-semibold">

                                <i class="fa-solid fa-arrow-left"></i>

                                Retour

                            </a>

                            <a href="{{ route('roles.edit',$role->id) }}"
                               class="flex-1 flex justify-center items-center gap-3 py-4 rounded-2xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold shadow-lg hover:scale-105 transition">

                                <i class="fa-solid fa-pen"></i>

                                Modifier le rôle

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Carte latérale -->

            <div>

                <div class="bg-white rounded-3xl shadow-xl p-8">

                    <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center mb-6">

                        <i class="fa-solid fa-circle-info text-blue-700 text-2xl"></i>

                    </div>

                    <h3 class="text-xl font-bold">

                        À propos

                    </h3>

                    <p class="text-gray-600 mt-4 leading-7">

                        Les rôles permettent de définir les permissions accordées aux utilisateurs.
                        Chaque rôle peut être associé à un ensemble d'autorisations spécifiques.

                    </p>

                </div>

                <div class="mt-6 bg-gradient-to-r from-blue-700 to-cyan-500 rounded-3xl p-8 text-white shadow-xl">

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center mb-5">

                        <i class="fa-solid fa-shield-halved text-2xl"></i>

                    </div>

                    <h3 class="text-2xl font-bold">

                        Sécurité

                    </h3>

                    <p class="mt-4 text-blue-100 leading-7">

                        Gérez soigneusement les rôles afin de garantir un contrôle d'accès sécurisé
                        et une administration efficace de la plateforme.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection