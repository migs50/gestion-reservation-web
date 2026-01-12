<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DemandeCompte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        

        $validated = $request->validate([
            'nom_complet' => 'required|string|max:150',
            'email' => 'required|email|max:191|unique:demande_comptes,email',
            'telephone' => 'required|string|max:30',
            'type_demande' => 'required|in:Interne,Responsable',
            'justification' => 'required|string',
            'secret_question' => 'required|string|max:255',   
            'secret_answer' => 'required|string|max:255', 
        ]);

        DemandeCompte::create([
            'nom_complet' => $validated['nom_complet'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'type_demande' => $validated['type_demande'],
            'justification' => $validated['justification'],
            'statut' => 'pending',
            'secret_question' => $validated['secret_question'],  
            'secret_answer' => $validated['secret_answer'],
        ]);

      return redirect()->route('register.success');

    }
    public function success()
        {
            return view('auth.register_success');
        }

}
