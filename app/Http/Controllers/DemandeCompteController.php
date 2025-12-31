<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemandeCompteController extends Controller
{
    /**
     * Afficher le formulaire de demande de compte
     */
    public function create()
    {
        return view('guest.demande-compte');
    }

    /**
     * Enregistrer la demande de compte
     */
    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required',
        'prenom' => 'required',
        'email' => 'required|email',
        'telephone' => 'required',
        'affiliation' => 'required',
        'accountType' => 'required',
        'fonction' => 'required',
        'projet' => 'required',
        'justification' => 'required|min:50',
        'acceptRules' => 'accepted',
    ]);

    // 👉 plus tard : enregistrer en base de données

        return redirect()
    ->route('register')
    ->with('success', 'Votre demande a été envoyée avec succès.');
}


    }