<?php

namespace App\Http\Controllers;

use App\Models\Ressource;
use Illuminate\Http\Request;

class RessourceController extends Controller
{
    // GET /ressources  -> ressources.index
    public function index()
    {
        $ressources = Ressource::with('reservations')->get();

        return view('publique.ressources', compact('ressources'));
    }
        // GET /ressources/{ressource} -> ressources.show

        public function show(Ressource $ressource)
        {
            return view('publique.ressources-details', compact('ressource'));
        }

}
