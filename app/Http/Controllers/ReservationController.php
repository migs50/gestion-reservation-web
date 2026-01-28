<?php
namespace App\Http\Controllers;

use App\Models\Ressource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationRequested;
use App\Models\Notification as NotificationModel;
use App\Models\Journal;


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

        return view('user.history', compact('reservations'));
    }

    public function create(Ressource $ressource)
    {
        return view('user.reservations.create', compact('ressource'));
    }

    public function store(Request $request)
    {
        //   dd('store hit', $request->all());
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
                'debut' => 'Cette ressource n’est pas disponible sur la période choisie (Conflit de réservation).',
            ]);
        }

        // Check for Maintenance (Indispo)
        $maintenance = \App\Models\Indispo::where('ressource_id', $ressource->id)
            ->where('actif', true)
            ->where(function ($q) use ($data) {
                $q->whereBetween('debut', [$data['debut'], $data['fin']])
                  ->orWhereBetween('fin', [$data['debut'], $data['fin']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('debut', '<=', $data['debut'])
                         ->where('fin', '>=', $data['fin']);
                  });
            })
            ->exists();

        if ($maintenance) {
            return back()->withInput()->withErrors([
                'debut' => 'Impossible de réserver : La ressource est en maintenance sur la période choisie.',
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

        // Logging
             Journal::create([
                'acteur_id'  => Auth::id(),
                'objet'      => 'reservation',
                'objet_id'   => $reservation->id,
                'action'     => 'create',
                'details'    => "Demande de réservation #{$reservation->id} pour la ressource {$ressource->nom}",
                'donnees'    => null,
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
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

        return view('user.reservations.show', compact('reservation'));
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

        // Logging
            Journal::create([
                'acteur_id'  => Auth::id(),
                'objet'      => 'reservation',
                'objet_id'   => $reservation->id,
                'action'     => 'cancel',
                'details'    => "Réservation #{$reservation->id} annulée par l'utilisateur",
                'donnees'    => null,
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
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
    public function responsableIndex()
{
    $user = auth()->user();

    $reservations = Reservation::whereHas('ressource', function ($q) use ($user) {
            $q->where('manager_id', $user->id);   // or whatever column stores responsable
        })
        ->with('demandeur', 'ressource')
        ->orderByDesc('debut')
        ->paginate(15);

    return view('responsable.reservations.index', compact('reservations'));
}

    
public function approve(Request $request, Reservation $reservation)
{
    $request->validate([
        'note_decision' => 'required|string|min:3',
    ]);

    $reservation->update([
        'statut'        => 'approved',
        'decideur_id'   => auth()->id(),
        'note_decision' => $request->note_decision,
    ]);

    Journal::create([
        'acteur_id'  => Auth::id(),
        'objet'      => 'reservation',
        'objet_id'   => $reservation->id,
        'action'     => 'approve',
        'details'    => "Réservation #{$reservation->id} approuvée avec note : {$request->note_decision}",
        'donnees'    => null,
        'ip'         => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    return back()->with('success', 'Réservation approuvée.');
}

public function refuse(Request $request, Reservation $reservation)
{
    $request->validate([
        'note_decision' => 'required|string|min:3',
    ]);

    $reservation->update([
        'statut'        => 'refused',
        'decideur_id'   => auth()->id(),
        'note_decision' => $request->note_decision,
    ]);

    Journal::create([
        'acteur_id'  => Auth::id(),
        'objet'      => 'reservation',
        'objet_id'   => $reservation->id,
        'action'     => 'refuse',
        'details'    => "Réservation #{$reservation->id} refusée avec note : {$request->note_decision}",
        'donnees'    => null,
        'ip'         => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    return back()->with('success', 'Réservation refusée.');
}

}
