@extends('base.admin')

@section('title','Administration des plaintes')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">

    <section class="bg-gradient-to-r from-blue-900 via-blue-700 to-cyan-600 text-white">
        <div class="container mx-auto px-6 py-10 flex flex-col lg:flex-row justify-between items-center gap-6">
            <div>
                <h1 class="text-4xl font-bold">
                    <i class="fa-solid fa-file-circle-exclamation mr-2"></i>
                    Administration des plaintes
                </h1>
                <p class="text-blue-100 mt-2">Consultez, traitez et suivez toutes les plaintes des citoyens.</p>
            </div>

            <a href="{{ route('complaints.create') }}"
               class="bg-white text-blue-700 px-6 py-3 rounded-xl font-semibold shadow hover:scale-105 transition">
                <i class="fa-solid fa-plus mr-2"></i>Nouvelle plainte
            </a>
        </div>
    </section>

    <div class="container mx-auto px-6 py-8">

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-blue-600">
                <i class="fa-solid fa-folder text-blue-600 text-2xl"></i>
                <p class="mt-3 text-gray-500">Total</p>
                {{-- <h2 class="text-3xl font-bold">{{ $total ?? ($complaints->count() ?? 0) }}</h2> --}}
            </div>

            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-gray-500">
                <i class="fa-solid fa-clock text-gray-600 text-2xl"></i>
                <p class="mt-3 text-gray-500">Enregistrées</p>
                <h2 class="text-3xl font-bold">{{ $enregistrees ?? 0 }}</h2>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-yellow-500">
                <i class="fa-solid fa-spinner text-yellow-500 text-2xl"></i>
                <p class="mt-3 text-gray-500">En cours</p>
                <h2 class="text-3xl font-bold">{{ $en_cours ?? 0 }}</h2>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-600">
                <i class="fa-solid fa-circle-check text-green-600 text-2xl"></i>
                <p class="mt-3 text-gray-500">Résolues</p>
                <h2 class="text-3xl font-bold">{{ $resolues ?? 0 }}</h2>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-5 mb-8">
            <form class="grid lg:grid-cols-5 gap-4">
                <div class="lg:col-span-2 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-gray-400"></i>
                    <input class="w-full border rounded-xl pl-11 pr-4 py-3" placeholder="Rechercher une plainte...">
                </div>
                <select class="border rounded-xl px-4 py-3">
                    <option>Tous les services</option>
                </select>
                <select class="border rounded-xl px-4 py-3">
                    <option>Tous les statuts</option>
                </select>
                <button class="bg-blue-700 text-white rounded-xl px-4 py-3">
                    <i class="fa-solid fa-filter mr-2"></i>Filtrer
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="px-6 py-5 border-b flex justify-between">
                <h2 class="text-2xl font-bold"><i class="fa-solid fa-table mr-2 text-blue-700"></i>Liste des plaintes</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left">#</th>
                            <th class="px-6 py-4 text-left">Citoyen</th>
                            <th class="px-6 py-4 text-left">Titre</th>
                            <th class="px-6 py-4 text-left">Service</th>
                            <th class="px-6 py-4 text-left">Statut</th>
                            <th class="px-6 py-4 text-left">Date</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($complaints ?? [] as $complaint)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-bold text-blue-700">#{{ $complaint->id }}</td>
                            <td class="px-6 py-4">{{ $complaint->user->name ?? 'Citoyen' }}</td>
                            <td class="px-6 py-4">{{ $complaint->titre }}</td>
                            <td class="px-6 py-4">{{ $complaint->service }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700">{{ ucfirst($complaint->statut) }}</span>
                            </td>
                            <td class="px-6 py-4">{{ optional($complaint->created_at)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('complaints.show',$complaint->id) }}" class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('complaints.edit',$complaint->id) }}" class="w-10 h-10 rounded-lg bg-yellow-100 text-yellow-700 flex items-center justify-center"><i class="fa-solid fa-pen"></i></a>
                                    <form method="POST" action="{{ route('complaints.destroy',$complaint->id) }}">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Supprimer cette plainte ?')" class="w-10 h-10 rounded-lg bg-red-100 text-red-700"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-16 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-5xl mb-4"></i>
                            <p>Aucune plainte trouvée.</p>
                        </td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($complaints) && method_exists($complaints,'links'))
            <div class="p-6 border-t">
                {{ $complaints->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection