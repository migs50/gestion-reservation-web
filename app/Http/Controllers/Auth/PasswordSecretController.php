<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordSecretController extends Controller
{
    public function showEmailForm()
    {
        return view('secret.email');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email introuvable']);
        }

        if (empty($user->secret_question)) {
        return back()->withErrors(['email' => 'Aucune question secrète configurée pour ce compte']);
    }

        session(['reset_user_id' => $user->id]);

        return redirect()->route('secret.question');
    }

    public function showQuestionForm()
    {
        if (!session('reset_user_id')) {
            return redirect()->route('secret.email');
        }

        $user = User::find(session('reset_user_id'));

        return view('secret.question', compact('user'));
    }

    public function resetPassword(Request $request)
    {
        $user = User::find(session('reset_user_id'));

        if (!$user) {
            return redirect()->route('secret.email');
        }

        if (!Hash::check($request->secret_answer, $user->secret_answer)) {
        return back()->withErrors(['secret_answer' => 'Réponse incorrecte']);
        }

        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget('reset_user_id');

        return redirect('/login')->with('success', 'Mot de passe réinitialisé avec succès');
    }
}
