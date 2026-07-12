@php
    $layout = match(auth()->user()?->role?->name) {
        'admin' => 'base.admin',
        'agent' => 'base.agent',
        'responsable' => 'base.responsable',
        default => 'base.user',
    };
@endphp
@extends($layout)

@section('title', 'Logs et traçabilité')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold"><i class="fa-solid fa-clock-rotate-left mr-2 text-blue-700"></i>Logs et traçabilité</h1>
        <p class="text-gray-500">
            @if($isAdmin ?? false)
                Historique complet de toutes les actions sur la plateforme
            @else
                Historique de vos actions personnelles
            @endif
        </p>
    </div>

    <form method="GET" class="bg-white rounded-2xl shadow p-4 flex flex-wrap gap-3 items-end">
        <div>
            <label class="text-xs text-gray-500">Action</label>
            <select name="action" class="border rounded-lg px-3 py-2 text-sm block">
                <option value="">Toutes</option>
                @foreach(['create','update','delete','assign','login'] as $a)
                <option value="{{ $a }}" @selected(request('action')===$a)>{{ ucfirst($a) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs text-gray-500">Du</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="border rounded-lg px-3 py-2 text-sm block">
        </div>
        <div>
            <label class="text-xs text-gray-500">Au</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="border rounded-lg px-3 py-2 text-sm block">
        </div>
        <button class="bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">Filtrer</button>
    </form>

    <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow p-5"><p class="text-sm text-gray-500">Aujourd'hui</p><p class="text-2xl font-bold">{{ $today_actions ?? 0 }}</p></div>
        <div class="bg-white rounded-2xl shadow p-5"><p class="text-sm text-gray-500">Cette semaine</p><p class="text-2xl font-bold">{{ $week_actions ?? 0 }}</p></div>
        <div class="bg-white rounded-2xl shadow p-5"><p class="text-sm text-gray-500">Ce mois</p><p class="text-2xl font-bold">{{ $month_actions ?? 0 }}</p></div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Utilisateur</th>
                        <th class="px-4 py-3 text-left">Action</th>
                        <th class="px-4 py-3 text-left">Détails</th>
                        <th class="px-4 py-3 text-left">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($logs ?? [] as $log)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td class="px-4 py-3">{{ $log->user?->name }} <span class="text-xs text-gray-400">({{ $log->user?->role?->name }})</span></td>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-gray-100 rounded-full text-xs">{{ $log->action }}</span></td>
                        <td class="px-4 py-3 max-w-xs truncate">{{ $log->details ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-12 text-center text-gray-500">Aucun log</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($logs) && $logs->hasPages())
        <div class="p-4 border-t">{{ $logs->links() }}</div>
        @endif
    </div>
</div>
@endsection
