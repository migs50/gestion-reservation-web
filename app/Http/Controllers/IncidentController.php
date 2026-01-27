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

        $incident = Incident::create([
            'declarant_id' => Auth::id(),
            'ressource_id' => $request->ressource_id,
            'titre' => $request->titre,
            'description' => $request->description,
            'statut' => 'open',
        ]);

        // 1. Notify Admins
        $admins = \App\Models\User::whereHas('role', function($q) {
            $q->where('nom', 'Admin');
        })->get();

        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'type' => 'incident', // Ensure this type is handled effectively now string
                'titre' => 'Nouvel incident signalé',
                'contenu' => "Un incident a été signalé par " . Auth::user()->nom . " : " . $request->titre,
                'lu' => false,
                'lien' => route('user.incidents.show', $incident->id)
            ]);
        }

        // 2. Notify Responsable (if resource has one)
        if ($request->ressource_id) {
            $ressource = Ressource::find($request->ressource_id);
            if ($ressource && $ressource->manager_id) {
                \App\Models\Notification::create([
                    'user_id' => $ressource->manager_id,
                    'type' => 'incident',
                    'titre' => 'Incident sur votre ressource',
                    'contenu' => "Incident signalé sur " . $ressource->nom . " : " . $request->titre,
                    'lu' => false,
                    'lien' => route('user.incidents.show', $incident->id)
                ]);
            }
        }

        return redirect()->route('user.incidents.index')
            ->with('success', 'Votre signalement a été enregistré et les responsables ont été notifiés.');
    }

    public function show(Incident $incident)
    {
        $user = Auth::user();
        $isCreator = $incident->declarant_id === $user->id;
        $isAdmin = $user->role && $user->role->nom === 'Admin';
        $isManager = $incident->ressource && $incident->ressource->manager_id === $user->id;

        if (! ($isCreator || $isAdmin || $isManager)) {
            abort(403);
        }

        return view('user.incidents.show', compact('incident'));
    }
}
