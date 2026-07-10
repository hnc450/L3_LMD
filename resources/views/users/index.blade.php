@extends('base.user')

@section('title','Tableau de bord - Citoyen')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">

    <div class="bg-gradient-to-r from-blue-900 via-blue-700 to-cyan-600 text-white">
        <div class="container mx-auto px-6 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-8">
                <div>
                    <h1 class="text-4xl font-bold mb-3">
                        <i class="fa-solid fa-gauge-high mr-2"></i>
                        Tableau de bord citoyen
                    </h1>
                    <p class="text-blue-100">
                        Consultez, suivez et gérez toutes vos plaintes depuis un seul espace.
                    </p>
                </div>

                <a href="{{ route('complaints.create') }}"
                   class="bg-white text-blue-700 px-6 py-3 rounded-xl font-semibold shadow-lg hover:scale-105 transition">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Nouvelle plainte
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-10">

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Total des plaintes</p>
                        <h2 class="text-4xl font-bold text-blue-700 mt-2">
                            {{ isset($complaints) ? $complaints->count() : 0 }}
                        </h2>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center">
                        <i class="fa-solid fa-folder-open text-2xl text-blue-700"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">En cours</p>
                        <h2 class="text-4xl font-bold text-yellow-500">{{ $en_cours ?? 0 }}</h2>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center">
                        <i class="fa-solid fa-spinner text-2xl text-yellow-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Résolues</p>
                        <h2 class="text-4xl font-bold text-green-600">{{ $resolues ?? 0 }}</h2>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Enregistrées</p>
                        <h2 class="text-4xl font-bold text-red-600">{{ $enregistrees ?? 0 }}</h2>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center">
                        <i class="fa-solid fa-file-circle-plus text-2xl text-red-600"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('complaints.create') }}" class="bg-blue-700 text-white px-5 py-3 rounded-xl hover:bg-blue-800 transition">
                    <i class="fa-solid fa-plus mr-2"></i>Nouvelle plainte
                </a>

                <a href="{{ route('notifications.index') }}" class="border border-blue-700 text-blue-700 px-5 py-3 rounded-xl hover:bg-blue-50 transition">
                    <i class="fa-solid fa-bell mr-2"></i>Notifications
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <div class="px-6 py-5 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-list mr-2 text-blue-700"></i>
                    Mes plaintes
                </h2>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left">#</th>
                        <th class="px-6 py-4 text-left">Titre</th>
                        <th class="px-6 py-4 text-left">Service</th>
                        <th class="px-6 py-4 text-left">Statut</th>
                        <th class="px-6 py-4 text-left">Date</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($plaintes  ?? [] as $complaint)

                    <tr class="border-b hover:bg-slate-50">

                        <td class="px-6 py-5 font-bold text-blue-700">#{{ $complaint->id }}</td>

                        <td class="px-6 py-5">{{ $complaint->title }}</td>

                        <td class="px-6 py-5">{{ ucfirst($complaint->service) }}</td>

                        <td class="px-6 py-5">

                            @if($complaint->statut=='enregistree')
                                <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm">Enregistrée</span>
                            @elseif($complaint->statut=='en_cours')
                                <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm">En cours</span>
                            @else
                                <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm">Résolue</span>
                            @endif

                        </td>

                        <td class="px-6 py-5">
                            {{ $complaint->created_at->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-5 text-center">

                            <a href="{{ route('complaint.show',$complaint->id) }}"
                               class="inline-flex items-center gap-2 bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">

                                <i class="fa-solid fa-eye"></i>
                                Voir

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center py-16">

                            <i class="fa-solid fa-inbox text-6xl text-gray-300 mb-6"></i>

                            <h3 class="text-2xl font-bold mb-2">Aucune plainte</h3>

                            <p class="text-gray-500 mb-6">Vous n'avez encore soumis aucune plainte.</p>

                            <a href="{{ route('complaints.create') }}"
                               class="bg-blue-700 text-white px-6 py-3 rounded-xl">

                                Déposer une plainte

                            </a>

                        </td>

                    </tr>

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
