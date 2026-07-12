<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StatistiqueController;
use App\Models\Feedback;
use App\Models\Plainte;
use App\Models\Service;
use App\Support\PlainteStatut;
use Illuminate\Http\Request;

class StatistiqueApiController extends Controller
{
    public function index(Request $request)
    {
        $total = Plainte::count();
        $resolved = Plainte::where('statut', PlainteStatut::RESOLUE)->count();

        $byStatus = collect(PlainteStatut::all())->map(fn ($s) => [
            'statut' => $s,
            'count' => Plainte::where('statut', $s)->count(),
        ]);

        $byService = Service::withCount('plaintes')->get()->map(fn ($s) => [
            'service' => $s->name,
            'count' => $s->plaintes_count,
        ]);

        return response()->json([
            'total' => $total,
            'resolution_rate' => $total > 0 ? round(($resolved / $total) * 100) : 0,
            'satisfaction' => round(Feedback::avg('note') ?? 0, 1),
            'by_status' => $byStatus,
            'by_service' => $byService,
        ]);
    }
}
