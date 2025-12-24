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

        // resources/views/ressources/index.blade.php
        return view('ressources.index', compact('ressources'));
    }

    // GET /ressources/{ressource} -> ressources.show
    public function show(Ressource $ressource)
    {
        // resources/views/ressources/show.blade.php
        return view('ressources.show', compact('ressource'));
    }
}
