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
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'affiliation' => 'required|string|max:255',
            'projet' => 'required|string|max:255',
            'justification' => 'required|string|min:100',
            'duree' => 'nullable|string',
            'ressources' => 'nullable|array',
        ]);

        // Pour l'instant, on va juste afficher un message de succès
        // Plus tard, on enregistrera dans la base de données
        
        // TODO: Sauvegarder dans la base de données
        // DemandeCompte::create($validated);
        
        // TODO: Envoyer un email de notification
        // Mail::to('admin@datacenter.ma')->send(new NouvelleDemande($validated));

        return redirect()->back()->with('success', 'Votre demande a été envoyée avec succès !');
    }
}