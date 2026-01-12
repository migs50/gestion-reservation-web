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
                'objet'      => 'reservation',              // required
                'objet_id'   => $reservation->id ?? null,   // if relevant
                'action'     => 'approbation_reservation',
                'details'    => "Réservation #{$reservation->id} APPROUVÉE pour l'utilisateur {$reservation->demandeur->nom}",
                'donnees'    => null,                       // or some array
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
                'objet'      => 'reservation',              // required
                'objet_id'   => $reservation->id ?? null,   // if relevant
                'action'     => 'approbation_reservation',
                'details'    => "Réservation #{$reservation->id} APPROUVÉE pour l'utilisateur {$reservation->demandeur->nom}",
                'donnees'    => null,                       // or some array
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        // Notify the requester
        $reservation->demandeur->notify(new ReservationDecision($reservation));

        return back()->with('success', 'Réservation refusée.');
    }

}
