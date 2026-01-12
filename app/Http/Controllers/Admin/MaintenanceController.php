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
        $maintenances = Indispo::with('ressource')
            ->orderBy('debut', 'desc')
            ->paginate(15);
            
        return view('admin.maintenance.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new maintenance period.
     */
    public function create()
    {
        $ressources = Ressource::where('actif', true)->orderBy('nom')->get();
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

        Indispo::create([
            'ressource_id' => $request->ressource_id,
            'created_by'   => Auth::id(),
            'type'         => $request->type,
            'debut'        => $request->debut,
            'fin'          => $request->fin,
            'raison'       => $request->raison,
            'actif'        => true,
        ]);

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Période de maintenance planifiée avec succès.');
    }

    /**
     * Show the form for editing the specified maintenance.
     */
    public function edit(Indispo $maintenance)
    {
        $ressources = Ressource::where('actif', true)->orderBy('nom')->get();
        return view('admin.maintenance.edit', compact('maintenance', 'ressources'));
    }

    /**
     * Update the specified maintenance in storage.
     */
    public function update(Request $request, Indispo $maintenance)
    {
        $request->validate([
            'ressource_id' => 'required|exists:ressources,id',
            'type'         => 'required|in:maintenance,inventory,repair,other',
            'debut'        => 'required|date',
            'fin'          => 'required|date|after:debut',
            'raison'       => 'required|string|max:500',
            'actif'        => 'required|boolean',
        ]);

        $maintenance->update($request->all());

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance mise à jour avec succès.');
    }

    /**
     * Remove the specified maintenance from storage.
     */
    public function destroy(Indispo $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Période de maintenance supprimée.');
    }
}
