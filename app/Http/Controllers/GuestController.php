<?php

namespace App\Http\Controllers;
use App\Models\Ressource;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Afficher la page d'accueil
     */
    public function index()
    {
        return view('guest.index');
    }

    /**
     * Afficher le catalogue des ressources
     */
    public function catalogue()
    {
    
        $ressources = Ressource::with('reservations')->get();

        return view('guest.catalogue', compact('ressources'));
    }

   /**
     * Afficher les règles d'utilisation
     */
    public function regles()
    {
        return view('guest.regles');
    }

}



