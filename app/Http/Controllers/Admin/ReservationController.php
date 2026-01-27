<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Ressource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Notifications\ReservationDecision;
use App\Models\Journal;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['ressource', 'demandeur'])
            ->orderBy('debut', 'desc')
            ->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $ressources = Ressource::orderBy('nom')->get();
        $users      = User::orderBy('nom')->orderBy('prenom')->get();

        return view('admin.reservations.create', compact('ressources', 'users'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'ressource_id'  => ['required', 'exists:ressources,id'],
        'user_id'       => ['required', 'exists:users,id'],
        'debut'         => ['required', 'date'],
        'fin'           => ['required', 'date', 'after:debut'],
        'justification' => ['required', 'string'],
    ]);

    $data = [
        'ressource_id'  => $validated['ressource_id'],
        'demandeur_id'  => $validated['user_id'],
        'debut'         => $validated['debut'],
        'fin'           => $validated['fin'],
        'justification' => $validated['justification'],
        'statut'        => 'pending',
    ];

    Reservation::create($data);

    return redirect()->route('admin.reservations.index')
        ->with('success', 'Réservation créée avec succès.');
}

    public function approve(Reservation $reservation)
    {
        $reservation->update([
            'statut'      => 'approved',
            'decideur_id' => Auth::id(),
        ]);

        Journal::create([
                'acteur_id'  => Auth::id(),
                'objet'      => 'reservation',
                'objet_id'   => $reservation->id,
                'action'     => 'approve',
                'details'    => "Réservation #{$reservation->id} APPROUVÉE pour l'utilisateur {$reservation->demandeur->nom}",
                'donnees'    => null,
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

        // Notify the requester
        $reservation->demandeur->notify(new ReservationDecision($reservation));

        return back()->with('success', 'Réservation approuvée.');
    }

    public function refuse(Reservation $reservation)
    {
        $reservation->update([
            'statut'      => 'refused',
            'decideur_id' => Auth::id(),
        ]);

        Journal::create([
                'acteur_id'  => Auth::id(),
                'objet'      => 'reservation',
                'objet_id'   => $reservation->id,
                'action'     => 'reject',
                'details'    => "Réservation #{$reservation->id} REFUSÉE pour l'utilisateur {$reservation->demandeur->nom}",
                'donnees'    => null,
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        // Notify the requester
        $reservation->demandeur->notify(new ReservationDecision($reservation));

        return back()->with('success', 'Réservation refusée.');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['ressource', 'demandeur', 'decideur']);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Afficher toutes les décisions des responsables techniques
     */
    public function decisions(Request $request)
    {
        $query = Reservation::with(['ressource.manager', 'demandeur', 'decideur'])
            ->whereNotNull('decideur_id')
            ->whereIn('statut', ['approved', 'refused']);

        // Filter by decision type
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filter by technician
        if ($request->filled('decideur_id')) {
            $query->where('decideur_id', $request->decideur_id);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('demandeur', function($sq) use ($request) {
                    $sq->where('nom', 'like', '%' . $request->search . '%')
                       ->orWhere('prenom', 'like', '%' . $request->search . '%');
                })->orWhereHas('ressource', function($sq) use ($request) {
                    $sq->where('nom', 'like', '%' . $request->search . '%');
                });
            });
        }

        $decisions = $query->latest('updated_at')->paginate(15);
        
        // Get all technicians for filter
        $decideurs = User::whereHas('role', function($q) {
            $q->where('nom', 'Responsable Technique');
        })->orderBy('nom')->get();

        return view('admin.reservations.decisions', compact('decisions', 'decideurs'));
    }

}
