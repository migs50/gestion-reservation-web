<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Journal;
use App\Models\Reservation;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $reservations = $user->reservations()
            ->with('decideur')
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'total_reservations' => $user->reservations()->count(),
            'pending' => $user->reservations()->where('statut', 'pending')->count(),
            'approved' => $user->reservations()->where('statut', 'approved')->count(),
            'active' => $user->reservations()->where('statut', 'active')->count(),
        ];

        return view('profile.index', compact('user', 'reservations', 'stats'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:80',
            'prenom' => 'required|string|max:80',
            'email' => 'required|email|max:191|unique:users,email,' . $user->id,
        ]);

        $oldData = $user->toArray();
        $user->update($validated);

        // Log profile update
        Journal::create([
            'acteur_id' => $user->id,
            'action' => 'update',
            'objet' => 'User',
            'objet_id' => $user->id,
            'details' => 'Mise à jour du profil'
        ]);

        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Log password change
        Journal::create([
            'acteur_id' => $user->id,
            'action' => 'update_password',
            'objet' => 'User',
            'objet_id' => $user->id,
            'details' => 'Changement de mot de passe'
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

    public function reservations()
    {
        $user = Auth::user();
        $reservations = $user->reservations()
            ->with(['decideur', 'affectations.ressource'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('profile.reservations', compact('reservations'));
    }
}
