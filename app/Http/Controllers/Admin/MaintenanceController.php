<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Indispo;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of planned maintenance.
     */
    public function index()
    {
        $query = Indispo::with('ressource');

        // Filter for Responsable Technique
        if (Auth::user()->role && Auth::user()->role->nom === 'Responsable Technique') {
            $query->whereHas('ressource', function($q) {
                $q->where('manager_id', Auth::id());
            });
        }

        $maintenances = $query->orderBy('debut', 'desc')->paginate(15);
            
        return view('admin.maintenance.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new maintenance period.
     */
    public function create()
    {
        $query = Ressource::where('actif', true);
        
        // Filter for Responsable Technique
        if (Auth::user()->role && Auth::user()->role->nom === 'Responsable Technique') {
            $query->where('manager_id', Auth::id());
        }

        $ressources = $query->orderBy('nom')->get();
        return view('admin.maintenance.create', compact('ressources'));
    }

    /**
     * Store a newly created maintenance in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ressource_id' => 'required|exists:ressources,id',
            'type'         => 'required|in:maintenance,inventory,repair,other',
            'debut'        => 'required|date',
            'fin'          => 'required|date|after:debut',
            'raison'       => 'required|string|max:500',
        ]);

        // Authorization check for Responsable
        $ressource = Ressource::findOrFail($request->ressource_id);
        if (Auth::user()->role && Auth::user()->role->nom === 'Responsable Technique') {
            if ($ressource->manager_id !== Auth::id()) {
                abort(403, 'Vous ne pouvez pas gérer la maintenance de cette ressource.');
            }
        }

        $maintenance = Indispo::create([
            'ressource_id' => $request->ressource_id,
            'created_by'   => Auth::id(),
            'type'         => $request->type,
            'debut'        => $request->debut,
            'fin'          => $request->fin,
            'raison'       => $request->raison,
            'actif'        => true,
        ]);

        // Notification: Notify all internal users about the maintenance
        $usersToNotify = \App\Models\User::whereHas('role', function($q) {
             $q->where('nom', 'Utilisateur');
        })->get();

        foreach ($usersToNotify as $user) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type' => 'message',
                'titre' => 'Maintenance Planifiée',
                'contenu' => "Une maintenance est prévue sur {$ressource->nom} du {$request->debut} au {$request->fin}.",
                'lu' => false,
            ]);
        }

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Période de maintenance planifiée avec succès.');
    }

    public function edit(Indispo $maintenance)
    {
        // Authorization check
        if (Auth::user()->role && Auth::user()->role->nom === 'Responsable Technique') {
            if ($maintenance->ressource->manager_id !== Auth::id()) {
                abort(403, 'Non autorisé.');
            }
        }

        $query = Ressource::where('actif', true);
        
        // Filter for Responsable Technique
        if (Auth::user()->role && Auth::user()->role->nom === 'Responsable Technique') {
            $query->where('manager_id', Auth::id());
        }

        $ressources = $query->orderBy('nom')->get();
        return view('admin.maintenance.edit', compact('maintenance', 'ressources'));
    }

    public function update(Request $request, Indispo $maintenance)
    {
        // Authorization check
        if (Auth::user()->role && Auth::user()->role->nom === 'Responsable Technique') {
            if ($maintenance->ressource->manager_id !== Auth::id()) {
                abort(403, 'Non autorisé.');
            }
        }

        $request->validate([
            'ressource_id' => 'required|exists:ressources,id',
            'type'         => 'required|in:maintenance,inventory,repair,other',
            'debut'        => 'required|date', // Removed 'start_date' typo if any
            'fin'          => 'required|date|after:debut',
            'raison'       => 'required|string|max:500',
            'actif'        => 'required|boolean',
        ]);

        $maintenance->update($request->all());

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Maintenance mise à jour avec succès.');
    }

    /**
     * Remove the specified maintenance from storage.
     */
    public function destroy(Indispo $maintenance)
    {
        // Authorization check
        if (Auth::user()->role && Auth::user()->role->nom === 'Responsable Technique') {
            if ($maintenance->ressource->manager_id !== Auth::id()) {
                abort(403, 'Non autorisé.');
            }
        }

        $maintenance->delete();

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Période de maintenance supprimée.');
    }
}
