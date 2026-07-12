<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Plainte;
use App\Models\Service;
use App\Models\User;
use App\Support\PlainteStatut;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        if (! Schema::hasTable('plaintes')) {
            return view('index', [
                'totalPlaintes' => 0,
                'tauxResolution' => 0,
                'totalAgents' => 0,
                'totalServices' => 0,
                'services' => collect(),
            ]);
        }

        $totalPlaintes = Plainte::count();
        $resolues = Plainte::where('statut', PlainteStatut::RESOLUE)->count();
        $tauxResolution = $totalPlaintes > 0 ? round(($resolues / $totalPlaintes) * 100) : 0;
        $totalAgents = User::whereHas('role', fn ($q) => $q->where('name', 'agent'))->count();
        $totalServices = Service::count();
        $services = Service::withCount('plaintes')->orderByDesc('plaintes_count')->take(8)->get();

        return view('index', compact(
            'totalPlaintes',
            'tauxResolution',
            'totalAgents',
            'totalServices',
            'services'
        ));
    }

    public function services()
    {
        $services = Service::with('responsable')->withCount('plaintes')->paginate(6);

        return view('services', compact('services'));
    }
}
