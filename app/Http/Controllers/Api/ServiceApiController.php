<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceApiController extends Controller
{
    public function index()
    {
        return response()->json(Service::with('responsable')->get());
    }

    public function show(Service $service)
    {
        return response()->json($service->load(['responsable', 'plaintes']));
    }
}
