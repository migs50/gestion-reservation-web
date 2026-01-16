<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeCompte;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;

class DemandeCompteController extends Controller
{
    // === existing methods ===

    public function create()
    {
        return view('publique.request-account');
    }

    public function store(Request $request)
    {
         $data = $request->validate([
        'nom'           => 'required|string|max:75',
        'prenom'        => 'required|string|max:75',
        'email'         => 'required|email|unique:users,email|unique:demande_comptes,email',
        'telephone'     => 'required|string|max:30',
        'type_demande'  => 'required|in:Interne,Responsable Technique',
        'justification' => 'required|string|min:50',
        'password'      => 'required|string|min:8|confirmed',
        'secret_question' => 'required|string|max:255',
        'secret_answer'   => 'required|string|max:255',

    ]);
    

    $passwordHash = Hash::make($data['password']);

    DemandeCompte::create([
        'nom_complet'   => $data['nom'] . ' ' . $data['prenom'],
        'email'         => $data['email'],
        'telephone'     => $data['telephone'],
        'type_demande'  => $data['type_demande'],   
        'justification' => $data['justification'],
        'password'      => $passwordHash,
        'statut'        => 'pending',
        'secret_question' => $data['secret_question'],
        'secret_answer'   => Hash::make($data['secret_answer']),

    ]);
        
        
        return redirect()
            ->route('register.success')
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
           
           // it only creates a user if one does not exist yet:(Avoid double creation for the same demande)
           $existing = User::where('email', $demande->email)->first();

           if (! $existing) {
                $user = User::create([
                    'nom'      => $demande->nom_complet, // if your users table has nom/prenom
                    'prenom'   => '',                    // or split the name if needed
                    'email'    => $demande->email,
                    'password' => $demande->password,
                    'role_id'  => 3, // normal user role id
                    'statut'   => 'active',
                    'secret_question' => $demande->secret_question,
                    'secret_answer'   => $demande->secret_answer,
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
