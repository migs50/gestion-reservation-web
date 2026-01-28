<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin,Responsable Technique']);
    }

    public function index()
    {
        // Fetch all incidents, latest first
        $incidents = Incident::with(['declarant', 'ressource', 'assigne'])
            ->latest()
            ->paginate(15);

        return view('admin.incidents.index', compact('incidents'));
    }

    public function show(Incident $incident)
    {
        return view('admin.incidents.show', compact('incident'));
    }

    public function update(Request $request, Incident $incident)
    {
        $validated = $request->validate([
            'statut' => 'required|in:open,in_progress,resolved,closed',
            'resolution_note' => 'nullable|string',
        ]);

        $oldStatus = $incident->statut;
        $incident->update($validated);

        // Notify user if status changed to resolved or closed
        if ($oldStatus !== $incident->statut && in_array($incident->statut, ['resolved', 'closed'])) {
            \App\Models\Notification::create([
                'user_id' => $incident->declarant_id,
                'type' => 'incident',
                'titre' => 'Incident mis à jour',
                'contenu' => "Votre incident #{$incident->id} est maintenant : " . $incident->statut,
                'lu' => false
            ]);
        }

        return back()->with('success', 'Incident mis à jour avec succès.');
    }

    public function resolve(Incident $incident)
    {
        $incident->update(['statut' => 'resolved']);
        return back()->with('success', 'Incident marqué comme résolu.');
    }
    
    public function close(Incident $incident)
    {
        $incident->update(['statut' => 'closed']);
        return back()->with('success', 'Incident clôturé.');
    }
}
