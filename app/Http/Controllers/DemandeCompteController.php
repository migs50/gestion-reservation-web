<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeCompte;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemandeCompteController extends Controller
{
    // === existing methods ===

    public function create()
    {
        return view('guest.demande-compte');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'          => 'required',
            'prenom'       => 'required',
            'email'        => 'required|email',
            'telephone'    => 'required',
            'affiliation'  => 'required',
            'accountType'  => 'required',
            'fonction'     => 'required',
            'projet'       => 'required',
            'justification'=> 'required|min:50',
            'acceptRules'  => 'accepted',
        ]);

        // plus tard: enregistrer en base ou rediriger
        return redirect()
            ->route('register')
            ->with('success', 'Votre demande a été envoyée avec succès.');
    }

    // === NEW ADMIN METHODS ===

    // List pending demandes
    public function index()
    {
        $demandes = DemandeCompte::where('statut', 'pending')->get();

        return view('admin.demandes.index', compact('demandes'));
    }

    // Accept a demande: create User + mark accepted
    public function accept(DemandeCompte $demande)
    {
           $password = 'secret123';
           // it only creates a user if one does not exist yet:(Avoid double creation for the same demande)
           $existing = User::where('email', $demande->email)->first();

           if (! $existing) {
                $user = User::create([
                    'nom'      => $demande->nom_complet, // if your users table has nom/prenom
                    'prenom'   => '',                    // or split the name if needed
                    'email'    => $demande->email,
                    'password' => Hash::make($password),
                    'role_id'  => 2, // normal user role id
                    'statut'   => 'active',
                ]);
           }

                $demande->update([
                    'statut'       => 'approved',
                    'decided_by'   => auth()->id(),
                    'note_decision'=> 'Compte créé',
                ]);

                return back()->with('success', 'Demande acceptée, compte utilisateur créé.');
    }

    // Reject a demande
    public function reject(DemandeCompte $demande)
    {
        $demande->update([
            'statut'       => 'refused',
            'decided_by'   => auth()->id(),
            'note_decision'=> 'Demande refusée',
        ]);

        return back()->with('success', 'Demande refusée.');
    }
}
