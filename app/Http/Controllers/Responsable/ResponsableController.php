<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponsableController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Responsable Technique']);
    }

    public function indexRessources(Request $request)
    {
        $user = Auth::user();
        $query = $user->managedRessources()->with('categorie');

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->whereHas('categorie', function($q) use ($request) {
                $q->where('nom', $request->type);
            });
        }

        if ($request->filled('status')) {
            $query->where('etat', $request->status);
        }

        $resources = $query->paginate(10);

        return view('responsable.ressources', compact('resources'));
    }

    public function createRessource()
    {
        $categories = \App\Models\Categorie::orderBy('nom')->get();
        // Responsable is automatically the manager
        return view('admin.ressources.create', compact('categories'));
    }

    public function storeRessource(Request $request)
    {
        $data = $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'nom'          => 'required|string|max:120',
            'code_inv'     => 'nullable|string|max:60',
            'emplacement'  => 'nullable|string|max:120',
            'description'  => 'nullable|string',
        ]);

        $data['manager_id'] = Auth::id();
        $data['etat'] = 'available';
        $data['actif'] = true;

        Ressource::create($data);

        return redirect()
            ->route('responsable.ressources')
            ->with('success', 'Ressource créée avec succès.');
    }

    public function indexRequests(Request $request)
    {
        $user = Auth::user();
        $managedIds = $user->managedRessources()->pluck('id');

        $query = Reservation::whereIn('ressource_id', $managedIds)
            ->with(['demandeur', 'ressource']);

        if ($request->filled('search')) {
            $query->whereHas('demandeur', function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%');
            })->orWhereHas('ressource', function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('statut', $request->status);
        }

        $stats = [
            'total' => Reservation::whereIn('ressource_id', $managedIds)->count(),
            'pending' => Reservation::whereIn('ressource_id', $managedIds)->where('statut', 'pending')->count(),
            'approved' => Reservation::whereIn('ressource_id', $managedIds)->whereIn('statut', ['approved', 'active'])->count(),
            'rejected' => Reservation::whereIn('ressource_id', $managedIds)->where('statut', 'rejected')->count(),
        ];

        $requests = $query->latest()->paginate(10);

        return view('responsable.requests', compact('requests', 'stats'));
    }

    public function approveRequest(Reservation $reservation)
    {
        $this->checkReservationAccess($reservation);
        
        $reservation->update([
            'statut' => 'approved',
            'decideur_id' => Auth::id(),
            'note_decision' => 'Approuvée par responsable technique'
        ]);

        // Notify the requester
        $reservation->demandeur->notify(new \App\Notifications\ReservationDecision($reservation));

        return back()->with('success', 'Demande approuvée.');
    }

    public function rejectRequest(Reservation $reservation)
    {
        $this->checkReservationAccess($reservation);

        $reservation->update([
            'statut' => 'rejected',
            'decideur_id' => Auth::id(),
            'note_decision' => 'Refusée par responsable technique'
        ]);

        // Notify the requester
        $reservation->demandeur->notify(new \App\Notifications\ReservationDecision($reservation));

        return back()->with('success', 'Demande refusée.');
    }

    public function showRequest(Reservation $reservation)
    {
        $this->checkReservationAccess($reservation);
        return view('responsable.approve-reservation', compact('reservation'));
    }

    public function maintenance(Ressource $resource)
    {
        $this->checkResourceAccess($resource);
        $resource->update(['etat' => 'maintenance']);

        // Notify users who have active or future reservations for this resource
        $impactedReservations = Reservation::where('ressource_id', $resource->id)
            ->whereIn('statut', ['approved', 'active', 'pending'])
            ->where('fin', '>', now())
            ->get();

        foreach ($impactedReservations as $res) {
            \App\Models\Notification::create([
                'user_id' => $res->demandeur_id,
                'type' => 'maintenance',
                'titre' => 'Maintenance sur ' . $resource->nom,
                'contenu' => 'La ressource ' . $resource->nom . ' a été mise en maintenance. Vos réservations en cours ou futures pourraient être impactées.',
                'lu' => false,
                'lien' => route('reservations.show', $res->id)
            ]);
        }

        return back()->with('success', 'Ressource mise en maintenance et utilisateurs notifiés.');
    }

    public function enable(Ressource $resource)
    {
        $this->checkResourceAccess($resource);
        $resource->update(['etat' => 'available', 'actif' => true]);
        return back()->with('success', 'Ressource activée.');
    }

    public function disable(Ressource $resource)
    {
        $this->checkResourceAccess($resource);
        $resource->update(['etat' => 'disabled', 'actif' => false]);
        return back()->with('success', 'Ressource désactivée.');
    }

    private function checkReservationAccess(Reservation $reservation)
    {
        if ($reservation->ressource->manager_id !== Auth::id()) {
            abort(403);
        }
    }

    private function checkResourceAccess(Ressource $resource)
    {
        if ($resource->manager_id !== Auth::id()) {
            abort(403);
        }
    }
}
