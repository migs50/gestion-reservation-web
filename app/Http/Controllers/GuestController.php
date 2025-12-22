<?php

namespace App\Http\Controllers;

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
        // Pour l'instant, retourner la vue sans données
        // Plus tard, on récupérera les ressources depuis la base de données
        
        return view('guest.catalogue');
    }

    /**
     * Afficher les règles d'utilisation
     */
    public function regles()
    {
        return view('guest.regles');
    }
}