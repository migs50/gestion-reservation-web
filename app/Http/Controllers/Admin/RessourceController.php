<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Ressource;
use App\Models\User;
use Illuminate\Http\Request;

class RessourceController extends Controller
{
    public function index()
{
    $ressources = Ressource::with(['categorie', 'manager'])
        ->orderBy('nom')
        ->paginate(15);

    return view('admin.ressources.index', compact('ressources'));
}

    public function __construct()
    {
        $this->middleware('auth');
        // You can later add role middleware here, e.g. 'role:Admin'
    }

    public function create()
    {

    // Liste des catégories pour le select
    $categories = Categorie::orderBy('nom')->get();

    // Liste des utilisateurs qui peuvent être managers
   $managers = User::orderBy('nom')->orderBy('prenom')->get(); // ou filtrer par rôle si besoin

    return view('admin.ressources.create', compact('categories', 'managers'));

    }

   public function store(Request $request)
{
    $data = $request->validate([
        'categorie_id' => 'required|exists:categories,id',
        'manager_id'   => 'nullable|exists:users,id',
        'nom'          => 'required|string|max:120',
        'code_inv'     => 'nullable|string|max:60',
        'etat'         => 'required|in:available,maintenance,disabled',
        'actif'        => 'required|boolean',
        'emplacement'  => 'nullable|string|max:120',
        'description'  => 'nullable|string',
    ]);

    Ressource::create($data);

    return redirect()
        ->route('publique.ressources')
        ->with('success', 'Ressource créée avec succès.');
        }
    public function show(Ressource $ressource)
    {
    return view('publique.ressource-show', compact('ressource'));
    }
}