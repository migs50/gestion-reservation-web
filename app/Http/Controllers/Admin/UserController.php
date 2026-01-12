<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Journal;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            // Mapping string role names from view to role_id if necessary, 
            // but let's assume the view sends 'admin' or 'utilisateur' and we check relationship or field.
            // If the user table has a 'role_id' and we want to filter by role name:
            $roleName = $request->role;
            $query->whereHas('role', function($q) use ($roleName) {
                $q->where('nom', 'like', "%{$roleName}%");
            });
        }

        $users = $query->with('role')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = \App\Models\Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'statut' => 'required|in:active,inactive',
        ]);

        User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'statut' => $request->statut,
        ]);

        Journal::create([
            'acteur_id' => Auth::id(),
            'action'    => 'creation_utilisateur',
            'details'   => "Utilisateur créé : {$request->nom} {$request->prenom} ({$request->email})",
            'ip'        => request()->ip()
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        $roles = \App\Models\Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'role_id' => $request->role_id,
        ]);

        Journal::create([
            'acteur_id' => Auth::id(),
            'action'    => 'modification_role',
            'details'   => "Rôle de l'utilisateur {$user->nom} #{$user->id} modifié vers rôle ID : {$request->role_id}",
            'ip'        => request()->ip()
        ]);

        return redirect()->route('admin.users')->with('success', 'Rôle de l\'utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Vous ne pouvez pas vous supprimer vous-même.');
        }

        $userDetails = "{$user->nom} {$user->prenom} ({$user->email})";
        $user->delete();

        Journal::create([
            'acteur_id' => Auth::id(),
            'action'    => 'suppression_utilisateur',
            'details'   => "Utilisateur supprimé : $userDetails",
            'ip'        => request()->ip()
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre statut.');
        }

        $user->statut = ($user->statut === 'active') ? 'inactive' : 'active';
        $user->save();

        Journal::create([
            'acteur_id' => Auth::id(),
            'action'    => 'toggle_statut_utilisateur',
            'details'   => "Statut de l'utilisateur {$user->nom} changé vers : {$user->statut}",
            'ip'        => request()->ip()
        ]);

        return back()->with('success', 'Statut de l\'utilisateur mis à jour.');
    }
}
