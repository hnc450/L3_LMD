@extends('base.base')
@section('title','Services publics - Gestion des plaintes')
@section('content')

<div class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-blue-50">

<section class="relative overflow-hidden bg-gradient-to-r from-blue-950 via-blue-800 to-cyan-600">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,.12),transparent_40%)]"></div>
    <div class="container mx-auto px-6 py-24 relative">
        <div class="max-w-4xl mx-auto text-center text-white">
            <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-semibold backdrop-blur">
                🇨🇩 Services publics
            </span>
            <h1 class="mt-6 text-5xl font-extrabold">Choisissez le service concerné</h1>
            <p class="mt-6 text-lg text-blue-100">
                Sélectionnez un domaine pour signaler un problème, suivre vos plaintes et contribuer à l'amélioration des services publics.
            </p>
        </div>
    </div>
</section>

<section class="-mt-12 relative z-10">
<div class="container mx-auto px-6">
<div class="grid gap-6 md:grid-cols-3">
<div class="rounded-3xl bg-white p-8 text-center shadow-xl"><div class="text-4xl font-bold text-blue-700">{{ $totals }}</div>
  <p class="mt-2 text-gray-500">Services disponibles</p></div>
<div class="rounded-3xl bg-white p-8 text-center shadow-xl"><div class="text-4xl font-bold text-blue-700">24/7</div>
  <p class="mt-2 text-gray-500">Plateforme disponible</p></div>
<div class="rounded-3xl bg-white p-8 text-center shadow-xl"><div class="text-4xl font-bold text-blue-700">100%</div>
  <p class="mt-2 text-gray-500">Suivi en ligne</p></div>
</div>
</div>
</section>

@guest
 <section class="py-12">
  <div class="container mx-auto px-6">

   <div class="flex flex-col items-center justify-between gap-6 rounded-3xl border border-yellow-200 bg-yellow-50 p-8 md:flex-row">
  <div>
    <h3 class="text-xl font-bold text-yellow-800">Connectez-vous</h3>
    <p class="mt-2 text-yellow-700">Créez un compte ou connectez-vous pour déposer une plainte, consulter son évolution et recevoir des notifications.</p>
    </div>
    <a href="{{ route('auth.login') }}" class="rounded-2xl bg-blue-600 px-8 py-3 font-semibold text-white transition hover:scale-105 hover:bg-blue-700">Se connecter</a>
    </div>
   </div>
 </section>
@endguest

<section class="pb-24">
<div class="container mx-auto px-6">
<div class="mb-12">
<h2 class="text-4xl font-bold text-slate-800">Services disponibles</h2>
<p class="mt-2 text-slate-500">Choisissez un service pour déposer une plainte.</p>
</div>

<div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
@foreach($services as $service)
<div class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
<div class="h-2 bg-gradient-to-r from-blue-600 to-cyan-500"></div>
<div class="p-8">
<div class="flex items-center justify-between">
@if($service->image)
<img src="{{ asset('storage/'.$service->image) }}" class="h-16 w-16 rounded-2xl object-cover">
@else
<div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-100">
<i class="fa-solid fa-building-columns text-3xl text-blue-700"></i>
</div>
@endif
<span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Disponible</span>
</div>
<h3 class="mt-6 text-2xl font-bold text-slate-800">{{ $service->name }}</h3>
<p class="mt-4 leading-7 text-slate-600">{{ $service->description }}</p>

<div class="mt-8">
@auth
<a href="{{ route('complaints.create',['service'=>$service->id]) }}" class="flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 py-4 font-semibold text-white transition hover:scale-[1.02]">
Déposer une plainte <i class="fa-solid fa-arrow-right"></i>
</a>
@else
<a href="{{ route('auth.login') }}" class="block rounded-2xl bg-slate-100 py-4 text-center font-semibold text-slate-700 transition hover:bg-slate-200">
Se connecter
</a>
@endauth
</div>
</div>
</div>
@endforeach
</div>
</div>
</section>

<section class="pb-24">
<div class="container mx-auto px-6">
<div class="rounded-[40px] bg-gradient-to-r from-blue-700 to-cyan-500 p-16 text-center text-white shadow-2xl">
<h2 class="text-4xl font-bold">Un problème non répertorié ?</h2>
<p class="mx-auto mt-4 max-w-2xl text-blue-100">Vous pouvez toujours déposer une plainte. Notre équipe la redirigera automatiquement vers le service compétent.</p>
<div class="mt-10">
<a href="{{ route('complaints.create') }}" class="rounded-2xl bg-white px-10 py-4 font-bold text-blue-700 shadow transition hover:scale-105">Créer une plainte</a>
</div>
</div>
</div>
</section>

</div>
@endsection