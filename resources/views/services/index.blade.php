@extends('base.admin')

@section('title','Gestion des services')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
<div class="container mx-auto px-6">
<div class="flex items-center justify-between mb-8 bg-white rounded-2xl shadow p-6 border">
<div>
<h1 class="text-3xl font-bold text-royal-blue-700 flex items-center gap-3">
<i class="fa-solid fa-building"></i> Gestion des services
</h1>
<p class="text-gray-500 mt-2">Administration des services publics</p>
</div>
<a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-royal-blue-600 text-white hover:bg-royal-blue-700">
<i class="fa-solid fa-plus"></i> Nouveau service
</a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
<div class="p-5 border-b flex justify-between">
<input type="text" placeholder="Rechercher un service..." class="w-80 rounded-xl border px-4 py-2 focus:ring-2 focus:ring-royal-blue-500">
</div>

<div class="overflow-x-auto">
<table class="min-w-full">
<thead class="bg-gray-100">
<tr>
<th class="px-6 py-4">Image</th>
<th class="px-6 py-4 text-left">Service</th>
<th class="px-6 py-4 text-left">Responsable</th>
<th class="px-6 py-4 text-left">Description</th>
<th class="px-6 py-4 text-left">Date</th>
<th class="px-6 py-4 text-center">Actions</th>
</tr>
</thead>
<tbody class="divide-y">
@forelse($services as $service)
<tr class="hover:bg-blue-50 transition">
<td class="px-6 py-4">
@if($service->image)
<img src="{{ asset('storage/'.$service->image) }}" class="w-14 h-14 rounded-xl object-cover">
@else
<div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">
<i class="fa-solid fa-building-columns text-blue-700 text-xl"></i>
</div>
@endif
</td>
<td class="px-6 py-4 font-semibold">{{ $service->name }}</td>
<td class="px-6 py-4">{{ $service->responsable->name ?? 'Non affecté' }}</td>
<td class="px-6 py-4">{{ Str::limit($service->description,60) }}</td>
<td class="px-6 py-4">{{ optional($service->created_at)->format('d/m/Y') }}</td>
<td class="px-6 py-4">
<div class="flex justify-center gap-2">
<a href="{{ route('admin.services.show',$service->id) }}" class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-700 hover:text-white flex items-center justify-center"><i class="fa-solid fa-eye"></i></a>
<a href="{{ route('admin.services.edit',$service->id) }}" class="w-10 h-10 rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-500 hover:text-white flex items-center justify-center"><i class="fa-solid fa-pen"></i></a>
<form method="POST" action="{{ route('admin.services.destroy',$service->id) }}">
@csrf @method('DELETE')
<button onclick="return confirm('Supprimer ce service ?')" class="w-10 h-10 rounded-lg bg-red-100 text-red-700 hover:bg-red-600 hover:text-white flex items-center justify-center"><i class="fa-solid fa-trash"></i></button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="6" class="py-16 text-center text-gray-400">
<i class="fa-solid fa-building-circle-xmark text-6xl mb-4"></i>
<p>Aucun service disponible.</p>
</td></tr>
@endforelse
</tbody>
</table>
</div>
@if(isset($services) && method_exists($services,'links'))
<div class="p-6 border-t">{{ $services->links() }}</div>
@endif
</div>
</div>
</div>
@endsection