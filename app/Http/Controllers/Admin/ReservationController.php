<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Ressource;
use App\Models\User;
use Illuminate\Http\Request;

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

}
