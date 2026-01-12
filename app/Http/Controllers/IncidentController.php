<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $incidents = Incident::with('ressource')
            ->where('declarant_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('user.incidents.index', compact('incidents'));
    }

    public function create()
    {
        $ressources = Ressource::where('actif', true)->orderBy('nom')->get();
        return view('user.incidents.create', compact('ressources'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:140',
            'description' => 'required|string',
            'ressource_id' => 'nullable|exists:ressources,id',
        ]);

        Incident::create([
            'declarant_id' => Auth::id(),
            'ressource_id' => $request->ressource_id,
            'titre' => $request->titre,
            'description' => $request->description,
            'statut' => 'open',
        ]);

        return redirect()->route('user.incidents.index')
            ->with('success', 'Votre signalement a été enregistré.');
    }

    public function show(Incident $incident)
    {
        if ($incident->declarant_id !== Auth::id()) {
            abort(403);
        }
        return view('user.incidents.show', compact('incident'));
    }
}
