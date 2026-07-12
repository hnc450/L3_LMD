@extends('base.admin')

@section('title','Gestion des utilisateurs')

@section('content')

<div class="min-h-screen bg-gray-50">

    <!-- HERO -->

    <section class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-blue-700 to-cyan-500">

        <div class="absolute -top-24 -left-24 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 py-14 relative">

            <div class="flex flex-col lg:flex-row justify-between items-center">

                <div class="text-white">

                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/20">

                        <i class="fa-solid fa-users mr-2"></i>

                        Administration

                    </span>

                    <h1 class="text-5xl font-bold mt-5">

                        Gestion des utilisateurs

                    </h1>

                    <p class="mt-4 text-blue-100 text-lg">

                        Gérez les comptes utilisateurs de votre plateforme.

                    </p>

                </div>

                <a href="{{ route('admin.users.create') }}"
                   class="mt-8 lg:mt-0 bg-white text-blue-700 px-6 py-4 rounded-2xl font-bold shadow-lg hover:scale-105 transition">

                    <i class="fa-solid fa-user-plus mr-2"></i>

                    Nouvel utilisateur

                </a>

            </div>

        </div>

    </section>

    <div class="container mx-auto px-6 -mt-10 relative z-10">

        <!-- Statistiques -->

        <div class="grid md:grid-cols-4 gap-6 mb-8">

            <div class="bg-white rounded-3xl shadow-lg p-6">

                <div class="flex justify-between">

                    <div>

                        <p class="text-gray-500">Utilisateur{{ $userCount > 0 ? 's' : ''}}</p>

                        <h2 class="text-4xl font-bold mt-2">

                            {{ $userCount ?? 0 }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">

                        <i class="fa-solid fa-users text-blue-700 text-2xl"></i>

                    </div>

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6">

                <div class="flex justify-between">

                    <div>

                        <p class="text-gray-500">

                            Administrateur{{ $adminCount > 0 ? 's' : '' }}

                        </p>

                        <h2 class="text-4xl font-bold">

                            {{ $adminCount ?? 0 }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center">

                        <i class="fa-solid fa-user-shield text-red-600 text-2xl"></i>

                    </div>

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6">

                <div class="flex justify-between">

                    <div>

                        <p class="text-gray-500">

                            Responsable{{ $responsablesCount > 0 ? 's' : '' }}

                        </p>

                        <h2 class="text-4xl font-bold">

                            {{ $responsablesCount ?? 0 }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center">

                        <i class="fa-solid fa-user-tie text-yellow-600 text-2xl"></i>

                    </div>

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6">

                <div class="flex justify-between">

                    <div>

                        <p class="text-gray-500">

                            Citoyen{{ $citoyensCount > 0 ? 's' : '' }}

                        </p>

                        <h2 class="text-4xl font-bold">

                            {{ $citoyensCount ?? 0 }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">

                        <i class="fa-solid fa-user text-green-600 text-2xl"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Table -->

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            <div class="p-6 border-b">

                <div class="flex flex-col lg:flex-row gap-4 justify-between">

                    <div class="relative w-full lg:w-96">

                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                        <input
                            type="text"
                            placeholder="Rechercher un utilisateur..."
                            class="w-full pl-12 pr-4 py-3 rounded-xl border">

                    </div>

                    <select class="px-5 py-3 rounded-xl border">

                        <option>Tous les rôles</option>

                    </select>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="px-6 py-4 text-left">Utilisateur</th>

                            <th class="px-6 py-4 text-left">Email</th>

                            <th class="px-6 py-4 text-left">Rôle</th>

                            <th class="px-6 py-4 text-left">Date</th>

                            <th class="px-6 py-4 text-center">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-4">

                                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">

                                        <i class="fa-solid fa-user text-blue-700"></i>

                                    </div>

                                    <div>

                                        <h3 class="font-semibold">

                                            {{ $user->name }}

                                        </h3>

                                    </div>

                                </div>

                            </td>

                            <td class="px-6">

                                {{ $user->email }}

                            </td>

                            <td class="px-6">

                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">

                                    {{ $user->role->name ?? '-' }}

                                </span>

                            </td>

                            <td class="px-6">

                                {{ $user->created_at->format('d/m/Y') }}

                            </td>

                            <td class="px-6">

                                <div class="flex justify-center gap-3">

                                    <a href="{{ route('admin.users.show',$user->id) }}"
                                       class="w-10 h-10 rounded-xl bg-blue-100 hover:bg-blue-200 flex items-center justify-center">

                                        <i class="fa-solid fa-eye text-blue-700"></i>

                                    </a>

                                    <a href="{{ route('admin.users.edit',$user->id) }}"
                                       class="w-10 h-10 rounded-xl bg-yellow-100 hover:bg-yellow-200 flex items-center justify-center">

                                        <i class="fa-solid fa-pen text-yellow-700"></i>

                                    </a>

                                    <form action="{{ route('admin.users.destroy',$user->id) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Supprimer cet utilisateur ?')"
                                            class="w-10 h-10 rounded-xl bg-red-100 hover:bg-red-200">

                                            <i class="fa-solid fa-trash text-red-700"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="py-20 text-center">

                                <i class="fa-solid fa-users text-6xl text-gray-300 mb-5"></i>

                                <h2 class="text-2xl font-bold text-gray-600">

                                    Aucun utilisateur

                                </h2>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if(method_exists($users,'links'))

            <div class="p-6">

                {{ $users->links() }}

            </div>

            @endif

        </div>

    </div>

</div>

@endsection