<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
       return view('index');
    }

    /**
     * Afficher la page des services (vue publique)
     */

    public function services()
    {
        $services = Service::where('responsable_id', '!=', null)->paginate(6); 
       
        return view('services', compact('services'));
    }
}
