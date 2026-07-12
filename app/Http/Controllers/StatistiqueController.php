<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Plainte;
use App\Models\Service;
use App\Models\Statistique;
use App\Support\PlainteAccess;
use App\Support\PlainteStatut;
use Illuminate\Support\Facades\Auth;

class StatistiqueController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $serviceFilter = null;

        if ($user->isResponsable()) {
            $serviceFilter = PlainteAccess::managedService($user);
            abort_unless($serviceFilter, 403, 'Aucun service assigné.');
        }

        $plainteQuery = Plainte::query();
        if ($serviceFilter) {
            $plainteQuery->where('id_service', $serviceFilter->id);
        }

        $total = (clone $plainteQuery)->count();
        $resolved = (clone $plainteQuery)->where('statut', PlainteStatut::RESOLUE)->count();
        $resolutionRate = $total > 0 ? round(($resolved / $total) * 100) : 0;

        $avgTime = (clone $plainteQuery)->where('statut', PlainteStatut::RESOLUE)
            ->selectRaw('AVG(julianday(updated_at) - julianday(created_at)) as avg_days')
            ->value('avg_days');

        $plainteIds = (clone $plainteQuery)->pluck('id');
        $satisfaction = Feedback::whereIn('id_plainte', $plainteIds)->avg('note');

        $servicesQuery = Service::withCount('plaintes');
        if ($serviceFilter) {
            $servicesQuery->where('id', $serviceFilter->id);
        }

        $serviceStats = $servicesQuery->get()->map(function ($service) use ($total) {
            $service->count = $service->plaintes_count;
            $service->percentage = $total > 0 ? round(($service->plaintes_count / $total) * 100) : 0;

            return $service;
        });

        $statuses = collect(PlainteStatut::all())->map(function ($name) use ($plainteQuery, $total) {
            $count = (clone $plainteQuery)->where('statut', $name)->count();

            return (object) [
                'name' => $name,
                'count' => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100) : 0,
            ];
        });

        $trendQuery = Plainte::where('created_at', '>=', now()->subDays(30));
        if ($serviceFilter) {
            $trendQuery->where('id_service', $serviceFilter->id);
        }

        $maxDayCount = max(1, (clone $trendQuery)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as cnt')
            ->groupBy('day')
            ->pluck('cnt')
            ->max() ?? 1);

        $trend = collect(range(29, 0))->map(function ($daysAgo) use ($maxDayCount, $serviceFilter) {
            $date = now()->subDays($daysAgo);
            $countQuery = Plainte::whereDate('created_at', $date);
            if ($serviceFilter) {
                $countQuery->where('id_service', $serviceFilter->id);
            }
            $count = $countQuery->count();

            return (object) [
                'date' => $date->format('d/m'),
                'count' => $count,
                'percentage' => max(5, round(($count / $maxDayCount) * 100)),
            ];
        });

        $agentsQuery = \App\Models\User::whereHas('role', fn ($q) => $q->where('name', 'agent'));
        if ($serviceFilter) {
            $agentsQuery->where('id_service', $serviceFilter->id)
                ->where('created_by', $user->id);
        }

        $agents = $agentsQuery->get()->map(function ($agent) use ($serviceFilter) {
            $assignedQuery = Plainte::where('agent_id', $agent->id);
            if ($serviceFilter) {
                $assignedQuery->where('id_service', $serviceFilter->id);
            }

            $plainteIds = (clone $assignedQuery)->pluck('id');

            return (object) [
                'nom' => $agent->name,
                'total' => (clone $assignedQuery)->count(),
                'resolved' => (clone $assignedQuery)->where('statut', PlainteStatut::RESOLUE)->count(),
                'avg_time' => round((clone $assignedQuery)->where('statut', PlainteStatut::RESOLUE)
                    ->selectRaw('AVG(julianday(updated_at) - julianday(created_at)) as avg_days')
                    ->value('avg_days') ?? 0),
                'satisfaction' => round(Feedback::whereIn('id_plainte', $plainteIds)->avg('note') ?? 0, 1),
            ];
        });

        if (! $serviceFilter) {
            $this->syncStatistiques();
        }

        return view('statistics.index', [
            'total' => $total,
            'resolutionRate' => $resolutionRate,
            'resolution_rate' => $resolutionRate,
            'avgTime' => round($avgTime ?? 0),
            'avg_time' => round($avgTime ?? 0),
            'satisfaction' => round($satisfaction ?? 0, 1),
            'serviceStats' => $serviceStats,
            'services' => $serviceStats,
            'statuses' => $statuses,
            'trend' => $trend,
            'agents' => $agents,
            'serviceFilter' => $serviceFilter,
        ]);
    }

    private function syncStatistiques(): void
    {
        Service::all()->each(function (Service $service) {
            $plainteIds = Plainte::where('id_service', $service->id)->pluck('id');
            $count = $plainteIds->count();
            $avgTime = Plainte::where('id_service', $service->id)
                ->where('statut', PlainteStatut::RESOLUE)
                ->selectRaw('AVG(julianday(updated_at) - julianday(created_at)) as avg_days')
                ->value('avg_days');
            $satisfaction = Feedback::whereIn('id_plainte', $plainteIds)->avg('note');

            Statistique::updateOrCreate(
                ['id_service' => $service->id],
                [
                    'nombre_plaintes' => $count,
                    'temps_moyen_resolution' => round($avgTime ?? 0),
                    'taux_satisfaction' => round($satisfaction ?? 0, 1),
                ]
            );
        });
    }
}
