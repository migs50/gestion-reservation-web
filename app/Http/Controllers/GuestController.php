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
        return view('publique.home');
    }

    /**
     * Afficher le catalogue des ressources
     */
    public function catalogue()
    {
        $ressources = Ressource::with('reservations')->get();

        return view('publique.ressources', compact('ressources'));
    }

    /**
     * Afficher les règles d'utilisation
     */
    public function rules()
    {
        return view('publique.rules');
    }
}
