<?php
use App\Models\Ressource;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('ressource')
            ->where('demandeur_id', 1) // TODO: Auth::id() plus tard
            .orderByDesc('debut')
            ->get();

        return view('reservations.list', compact('reservations'));
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

        Reservation::create([
            'demandeur_id'  => 1, // TODO: Auth::id() (WISSAL doit developpe la partie auth)
            'ressource_id'  => $ressource->id,
            'decideur_id'   => null,
            'debut'         => $data['debut'],
            'fin'           => $data['fin'],
            'justification' => $data['justification'],
            'statut'        => 'pending',
            'note_decision' => null,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Demande de réservation enregistrée.');
    }
}
