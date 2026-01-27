<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
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
