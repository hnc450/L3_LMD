@extends('base.admin')

@section('title','Administration des rôles')

@section('content')

<div class="min-h-screen bg-gray-50">

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-blue-700 to-cyan-500">

        <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 py-14 relative">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                <div>

                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 text-white text-sm">

                        <i class="fa-solid fa-user-shield mr-2"></i>

                        Administration

                    </span>

                    <h1 class="text-5xl font-bold text-white mt-5">

                        Gestion des rôles

                    </h1>

                    <p class="text-blue-100 mt-4 text-lg">

                        Gérez les rôles et les permissions des utilisateurs de votre plateforme.

                    </p>

                </div>

                <a href="{{ route('admin.roles.create') }}"
                   class="inline-flex items-center justify-center gap-3 bg-white text-blue-700 px-8 py-4 rounded-2xl font-semibold shadow-xl hover:scale-105 transition">

                    <i class="fa-solid fa-plus"></i>

                    Nouveau rôle

                </a>

            </div>

        </div>

    </section>

    <div class="container mx-auto px-6 -mt-10 relative z-10">

        <!-- Statistiques -->

        <div class="grid md:grid-cols-3 gap-6 mb-10">

            <div class="bg-white rounded-3xl shadow-lg p-8">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500">

                            Total des rôles

                        </p>

                        <h2 class="text-4xl font-bold text-blue-700 mt-2">

                            {{ isset($roles) ? $roles->count() : 0 }}

                        </h2>

                    </div>

                    <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center">

                        <i class="fa-solid fa-users-gear text-2xl text-blue-700"></i>

                    </div>

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-lg p-8">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500">

                            Statut

                        </p>

                        <h2 class="text-3xl font-bold text-green-600 mt-2">

                            Actif

                        </h2>

                    </div>

                    <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center">

                        <i class="fa-solid fa-circle-check text-2xl text-green-600"></i>

                    </div>

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-lg p-8">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500">

                            Dernière mise à jour

                        </p>

                        <h2 class="text-xl font-bold text-gray-700 mt-2">

                            Aujourd'hui

                        </h2>

                    </div>

                    <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center">

                        <i class="fa-solid fa-clock-rotate-left text-2xl text-yellow-600"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Tableau -->

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            <div class="flex justify-between items-center p-8 border-b">

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">

                        Liste des rôles

                    </h2>

                    <p class="text-gray-500 mt-2">

                        Consultez, modifiez ou supprimez un rôle.

                    </p>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-8 py-5 text-left text-xs uppercase text-gray-500">

                                ID

                            </th>

                            <th class="px-8 py-5 text-left text-xs uppercase text-gray-500">

                                Nom

                            </th>

                            <th class="px-8 py-5 text-left text-xs uppercase text-gray-500">

                                Créé le

                            </th>

                            <th class="px-8 py-5 text-center text-xs uppercase text-gray-500">

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($roles ?? [] as $role)

                        <tr class="border-b hover:bg-blue-50 transition">

                            <td class="px-8 py-5 font-semibold text-blue-700">

                                #{{ $role->id }}

                            </td>

                            <td class="px-8 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center">

                                        <i class="fa-solid fa-user-shield text-blue-700"></i>

                                    </div>

                                    <div>

                                        <p class="font-semibold">

                                            {{ $role->name }}

                                        </p>

                                        <p class="text-gray-500 text-sm">

                                            Rôle système

                                        </p>

                                    </div>

                                </div>

                            </td>

                            <td class="px-8 py-5 text-gray-600">

                                {{ $role->created_at ? $role->created_at->format('d/m/Y') : '-' }}

                            </td>

                            <td class="px-8 py-5">

                                <div class="flex justify-center gap-3">

                                    <a href="{{ route('admin.roles.show',$role->id) }}"
                                       class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center hover:bg-blue-700 hover:text-white transition">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>

                                    <a href="{{ route('admin.roles.edit',$role->id) }}"
                                       class="w-10 h-10 rounded-xl bg-green-100 text-green-700 flex items-center justify-center hover:bg-green-700 hover:text-white transition">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.roles.destroy',$role->id) }}"
                                          onsubmit="return confirm('Supprimer ce rôle ?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="w-10 h-10 rounded-xl bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4" class="py-20 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mb-6">

                                        <i class="fa-solid fa-users-slash text-4xl text-blue-600"></i>

                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-700">

                                        Aucun rôle trouvé

                                    </h3>

                                    <p class="text-gray-500 mt-3">

                                        Commencez par créer votre premier rôle.

                                    </p>

                                    <a href="{{ route('admin.roles.create') }}"
                                       class="mt-8 px-8 py-4 rounded-xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold hover:scale-105 transition">

                                        <i class="fa-solid fa-plus mr-2"></i>

                                        Créer un rôle

                                    </a>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if(isset($roles) && method_exists($roles,'links'))

        <div class="mt-8">

            {{ $roles->links() }}

        </div>

        @endif

    </div>

</div>

@endsection