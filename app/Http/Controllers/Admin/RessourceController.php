<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Ressource;
use App\Models\User;
use Illuminate\Http\Request;

class RessourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // + éventuellement middleware role:Admin
    }

    /** Liste paginée des ressources (admin) */
    public function index()
    {
        $ressources = Ressource::with(['categorie', 'manager'])
            ->orderBy('nom')
            ->paginate(15);

        return view('admin.ressources.index', compact('ressources'));
    }

    /** Formulaire de création */
    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();
        $managers   = User::orderBy('nom')->orderBy('prenom')->get(); // filtrer par rôle si besoin

        return view('admin.ressources.create', compact('categories', 'managers'));
    }

    /** Enregistrement d’une nouvelle ressource */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        Ressource::create($data);

        return redirect()
            ->route('admin.ressources.index')
            ->with('success', 'Ressource créée avec succès.');
    }

    /** Formulaire d’édition d’une ressource existante */
    public function edit(Ressource $ressource)
    {
        $categories = Categorie::orderBy('nom')->get();
        $managers   = User::orderBy('nom')->orderBy('prenom')->get();

        return view('admin.ressources.edit', compact('ressource', 'categories', 'managers'));
    }

    /** Mise à jour d’une ressource */
    public function update(Request $request, Ressource $ressource)
    {
        $data = $this->validateData($request);

        $ressource->update($data);

        return redirect()
            ->route('admin.ressources.index')
            ->with('success', 'Ressource mise à jour.');
    }

    /** Activer / désactiver rapidement (AJAX ou formulaire) */
    public function toggleActif(Ressource $ressource)
    {
        $ressource->actif = ! $ressource->actif;
        $ressource->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'actif'   => $ressource->actif,
            ]);
        }

        return back()->with('success', 'Statut de la ressource mis à jour.');
    }

    /** Affichage public d’une ressource (page publique) */
    public function show(Ressource $ressource)
    {
        return view('publique.ressource-show', compact('ressource'));
    }

    /** Validation réutilisable */
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'manager_id'   => 'nullable|exists:users,id',
            'nom'          => 'required|string|max:120',
            'code_inv'     => 'nullable|string|max:60',
            'etat'         => 'required|in:available,maintenance,disabled',
            'actif'        => 'required|boolean',
            'emplacement'  => 'nullable|string|max:120',
            'description'  => 'nullable|string',
            'cpu'          => 'nullable|string|max:255',
            'ram'          => 'nullable|string|max:255',
            'os'           => 'nullable|string|max:255',
            'bande_passante' => 'nullable|string|max:255',
            'capacite'     => 'nullable|string|max:255',
            'type_stockage' => 'nullable|string|max:255',
        ]);
    }
}