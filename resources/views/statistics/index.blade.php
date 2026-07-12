@extends(auth()->user()?->isResponsable() ? 'base.responsable' : 'base.admin')

@section('title', 'Statistiques - Plateforme de Plaintes')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-royal-blue-700">Statistiques</h1>
            <p class="text-gray-600 mt-2">
                @if(isset($serviceFilter) && $serviceFilter)
                    Analyse du service : <strong>{{ $serviceFilter->name }}</strong>
                @else
                    Analyse des performances et tendances des plaintes
                @endif
            </p>
        </div>
        
        <!-- Period Filter -->
        <div class="bg-white p-4 rounded-lg shadow-lg mb-6">
            <div class="flex gap-4 flex-wrap items-center">
                <span class="text-sm font-medium text-gray-700">Période:</span>
                <button class="px-4 py-2 bg-royal-blue-600 text-white rounded-lg hover:bg-royal-blue-700 transition-colors">
                    7 jours
                </button>
                <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    30 jours
                </button>
                <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    90 jours
                </button>
                <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    1 an
                </button>
            </div>
        </div>
        
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total plaintes</p>
                        <p class="text-3xl font-bold text-royal-blue-700">{{ $total ?? 0 }}</p>
                        <p class="text-xs text-green-600 mt-1">+12% vs période précédente</p>
                    </div>
                    <div class="w-12 h-12 bg-royal-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📋</span>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Taux de résolution</p>
                        <p class="text-3xl font-bold text-green-600">{{ $resolution_rate ?? 0 }}%</p>
                        <p class="text-xs text-green-600 mt-1">+5% vs période précédente</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">✅</span>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Temps moyen</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $avg_time ?? 0 }}j</p>
                        <p class="text-xs text-green-600 mt-1">-2j vs période précédente</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">⏱️</span>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Satisfaction</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $satisfaction ?? 0 }}/5</p>
                        <p class="text-xs text-green-600 mt-1">+0.3 vs période précédente</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">⭐</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Complaints by Service -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-royal-blue-700 mb-4">Plaintes par service</h3>
                <div class="space-y-4">
                    @foreach($services ?? [] as $service)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">{{ ucfirst($service->name ?? 'Service') }}</span>
                            <span class="text-gray-600">{{ $service->count ?? 0 }} ({{ $service->percentage ?? 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-royal-blue-600 h-3 rounded-full" style="width: {{ $service->percentage ?? 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Complaints by Status -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-royal-blue-700 mb-4">Plaintes par statut</h3>
                <div class="space-y-4">
                    @foreach($statuses ?? [] as $status)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">{{ ucfirst($status->name ?? 'Statut') }}</span>
                            <span class="text-gray-600">{{ $status->count ?? 0 }} ({{ $status->percentage ?? 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            @switch($status->name ?? '')
                                @case('enregistree')
                                    <div class="bg-red-500 h-3 rounded-full" style="width: {{ $status->percentage ?? 0 }}%"></div>
                                    @break
                                @case('en_cours')
                                    <div class="bg-yellow-500 h-3 rounded-full" style="width: {{ $status->percentage ?? 0 }}%"></div>
                                    @break
                                @case('resolue')
                                    <div class="bg-green-500 h-3 rounded-full" style="width: {{ $status->percentage ?? 0 }}%"></div>
                                    @break
                                @default
                                    <div class="bg-gray-500 h-3 rounded-full" style="width: {{ $status->percentage ?? 0 }}%"></div>
                            @endswitch
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Trend Chart -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-royal-blue-700 mb-4">Évolution des plaintes (30 derniers jours)</h3>
            <div class="h-64 flex items-end justify-between gap-2">
                @foreach($trend ?? [] as $day)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-royal-blue-400 rounded-t" style="height: {{ $day->percentage ?? 10 }}%"></div>
                    <span class="text-xs text-gray-600 mt-2">{{ $day->date ?? '' }}</span>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Performance by Agent -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-royal-blue-700 mb-4">Performance des agents</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plaintes traitées</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Résolues</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temps moyen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satisfaction</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($agents ?? [] as $agent)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $agent->nom ?? 'N/A' }} {{ $agent->prenom ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $agent->total ?? 0 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $agent->resolved ?? 0 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $agent->avg_time ?? 0 }}j</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $agent->satisfaction ?? 0 }}/5</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
