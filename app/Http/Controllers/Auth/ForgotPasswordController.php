<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Afficher le formulaire pour entrer l'email
     */
    public function showEmailForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Vérifier l'email et afficher la question secrète
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Aucun compte trouvé avec cet email.']);
        }

        if (empty($user->secret_question) || empty($user->secret_answer)) {
            return back()->withErrors(['email' => 'Aucune question secrète configurée pour ce compte.']);
        }

        // Stocker l'ID utilisateur en session
        session(['reset_user_id' => $user->id]);

        return view('auth.passwords.secret-question', [
            'secret_question' => $user->secret_question
        ]);
    }

    /**
     * Vérifier la réponse à la question secrète
     */
    public function checkSecretAnswer(Request $request)
    {
        $request->validate([
            'secret_answer' => 'required|string',
        ]);

        if (!session('reset_user_id')) {
            return redirect()->route('password.request');
        }

        $user = User::find(session('reset_user_id'));

        if (!$user) {
            return redirect()->route('password.request');
        }

        $userAnswer = strtolower(trim($request->secret_answer));
        $correctAnswer = strtolower(trim($user->secret_answer));

        if ($userAnswer !== $correctAnswer) {
            return back()->withErrors(['secret_answer' => 'Réponse incorrecte.']);
        }

        // Réponse correcte, afficher le formulaire de nouveau mot de passe
        return view('auth.passwords.reset');
    }

    /**
     * Réinitialiser le mot de passe
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!session('reset_user_id')) {
            return redirect()->route('password.request');
        }

        $user = User::find(session('reset_user_id'));

        if (!$user) {
            return redirect()->route('password.request');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Nettoyer la session
        session()->forget('reset_user_id');

        return redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès !');
    }
}