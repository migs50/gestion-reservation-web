<?php
namespace App\Http\Controllers;

use App\Models\Ressource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationRequested;
use App\Models\Notification as NotificationModel;


class ReservationController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }



    public function index(Request $request)
    {
        $query = Reservation::with('ressource')
            ->where('demandeur_id', Auth::id());

        // Filters
        if ($request->filled('ressource')) {
            $query->whereHas('ressource', function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->ressource . '%');
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('debut', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('fin', '<=', $request->date_fin);
        }

        $reservations = $query->orderByDesc('debut')
            ->paginate(15);

        return view('profile.reservations', compact('reservations'));
    }

    public function create(Ressource $ressource)
    {
        return view('reservations.create', compact('ressource'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ressource_id'  => 'required|exists:ressources,id',
            'debut'         => 'required|date|after:now',
            'fin'           => 'required|date|after:debut',
            'justification' => 'required|string',
        ]);

        $ressource = Ressource::findOrFail($data['ressource_id']);

        $conflit = Reservation::where('ressource_id', $ressource->id)
            ->whereIn('statut', ['pending', 'approved', 'active'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('debut', [$data['debut'], $data['fin']])
                  ->orWhereBetween('fin', [$data['debut'], $data['fin']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('debut', '<=', $data['debut'])
                         ->where('fin', '>=', $data['fin']);
                  });
            })
            ->exists();

        if ($conflit) {
            return back()->withInput()->withErrors([
                'debut' => 'Cette ressource n’est pas disponible sur la période choisie.',
            ]);
        }

        $reservation = Reservation::create([
            'demandeur_id'  => Auth::id(),
            'ressource_id'  => $ressource->id,
            'decideur_id'   => null,
            'debut'         => $data['debut'],
            'fin'           => $data['fin'],
            'justification' => $data['justification'],
            'statut'        => 'pending',
            'note_decision' => null,
        ]);

        // Trigger notifications

        if ($ressource->manager_id && $manager = \App\Models\User::find($ressource->manager_id)) {
            $manager->notify(new ReservationRequested($reservation));
        }



        

        return redirect()->route('reservations.index')
            ->with('success', 'Demande de réservation enregistrée.');
    }

    /**
     * Display the specified reservation
     */
    public function show(Reservation $reservation)
    {
        // Check if user is authorized to view this reservation
        if ($reservation->demandeur_id !== Auth::id() && 
            !Auth::user()->hasRole('Admin') && 
            !Auth::user()->hasRole('Responsable Technique')) {
            abort(403, 'Non autorisé');
        }

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Cancel a reservation
     */
    public function cancel(Reservation $reservation)
    {
        // Check if user is authorized to cancel
        if ($reservation->demandeur_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        // Can only cancel pending or approved reservations
        if (!in_array($reservation->statut, ['pending', 'approved'])) {
            return back()->withErrors(['error' => 'Cette réservation ne peut pas être annulée.']);
        }

        $reservation->update([
            'statut' => 'cancelled'
        ]);

        // Notify user
        if (class_exists(\App\Models\Notification::class)) {
            \App\Models\Notification::create([
                'user_id' => $reservation->demandeur_id,
                'type' => 'message',
                'titre' => 'Réservation annulée',
                'message' => "Votre réservation #{$reservation->id} a été annulée.",
                'lu' => false
            ]);
        }



        return redirect()->route('reservations.index')
            ->with('success', 'Demande de réservation enregistrée.');
    }
}
