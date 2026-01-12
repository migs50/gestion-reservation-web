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
        return view('responsable.ressources-create', compact('categories'));
    }

    public function storeRessource(Request $request)
    {
        $data = $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'nom'          => 'required|string|max:120',
            'code_inv'     => 'nullable|string|max:60',
            'emplacement'  => 'nullable|string|max:120',
            'description'  => 'nullable|string',
            'cpu'          => 'nullable|string|max:255',
            'ram'          => 'nullable|string|max:255',
            'os'           => 'nullable|string|max:255',
            'bande_passante' => 'nullable|string|max:255',
            'capacite'     => 'nullable|string|max:255',
            'type_stockage' => 'nullable|string|max:255',
        ]);

        $data['manager_id'] = Auth::id();
        $data['etat'] = 'available';
        $data['actif'] = true;

        $ressource = Ressource::create($data);

        \App\Models\Journal::create([
            'acteur_id'  => Auth::id(),
            'objet'      => 'ressource',
            'objet_id'   => $ressource->id,
            'action'     => 'create',
            'details'    => "Ressource créée par responsable : {$ressource->nom}",
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()
            ->route('responsable.ressources')
            ->with('success', 'Ressource créée avec succès.');
    }

    public function editRessource(Ressource $resource)
    {
        $this->checkResourceAccess($resource);
        $categories = \App\Models\Categorie::orderBy('nom')->get();
        return view('responsable.ressources-edit', compact('resource', 'categories'));
    }

    public function updateRessource(Request $request, Ressource $resource)
    {
        $this->checkResourceAccess($resource);
        
        $data = $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'nom'          => 'required|string|max:120',
            'code_inv'     => 'nullable|string|max:60',
            'emplacement'  => 'nullable|string|max:120',
            'description'  => 'nullable|string',
            'cpu'          => 'nullable|string|max:255',
            'ram'          => 'nullable|string|max:255',
            'os'           => 'nullable|string|max:255',
            'bande_passante' => 'nullable|string|max:255',
            'capacite'     => 'nullable|string|max:255',
            'type_stockage' => 'nullable|string|max:255',
        ]);

        $resource->update($data);

        \App\Models\Journal::create([
            'acteur_id'  => Auth::id(),
            'objet'      => 'ressource',
            'objet_id'   => $resource->id,
            'action'     => 'update',
            'details'    => "Ressource modifiée par responsable : {$resource->nom}",
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()
            ->route('responsable.ressources')
            ->with('success', 'Ressource mise à jour.');
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

    public function approveRequest(Request $request, Reservation $reservation)
    {
        $this->checkReservationAccess($reservation);
        
        $request->validate([
            'note_decision' => 'nullable|string|max:500'
        ]);

        $reservation->update([
            'statut' => 'approved',
            'decideur_id' => Auth::id(),
            'note_decision' => $request->note_decision ?: 'Approuvée par responsable technique'
        ]);

        // Notify the requester
        $reservation->demandeur->notify(new \App\Notifications\ReservationDecision($reservation));

        \App\Models\Journal::create([
            'acteur_id'  => Auth::id(),
            'objet'      => 'reservation',
            'objet_id'   => $reservation->id,
            'action'     => 'approve',
            'details'    => "Demande approuvée par responsable : #{$reservation->id}",
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('responsable.requests')->with('success', 'Demande approuvée.');
    }

    public function rejectRequest(Request $request, Reservation $reservation)
    {
        $this->checkReservationAccess($reservation);

        $request->validate([
            'note_decision' => 'required|string|max:500'
        ]);

        $reservation->update([
            'statut' => 'rejected',
            'decideur_id' => Auth::id(),
            'note_decision' => $request->note_decision
        ]);

        // Notify the requester
        $reservation->demandeur->notify(new \App\Notifications\ReservationDecision($reservation));

        \App\Models\Journal::create([
            'acteur_id'  => Auth::id(),
            'objet'      => 'reservation',
            'objet_id'   => $reservation->id,
            'action'     => 'reject',
            'details'    => "Demande refusée par responsable : #{$reservation->id}",
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('responsable.requests')->with('success', 'Demande refusée.');
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

        \App\Models\Journal::create([
            'acteur_id'  => Auth::id(),
            'objet'      => 'ressource',
            'objet_id'   => $resource->id,
            'action'     => 'maintenance',
            'details'    => "Ressource mise en maintenance par responsable : {$resource->nom}",
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Ressource mise en maintenance et utilisateurs notifiés.');
    }
    public function enable(Ressource $resource)
    {
        $this->checkResourceAccess($resource);
        $resource->update(['etat' => 'available', 'actif' => true]);

        \App\Models\Journal::create([
            'acteur_id'  => Auth::id(),
            'objet'      => 'ressource',
            'objet_id'   => $resource->id,
            'action'     => 'activate',
            'details'    => "Ressource activée par responsable : {$resource->nom}",
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Ressource activée.');
    }

    public function disable(Ressource $resource)
    {
        $this->checkResourceAccess($resource);
        $resource->update(['etat' => 'disabled', 'actif' => false]);

        \App\Models\Journal::create([
            'acteur_id'  => Auth::id(),
            'objet'      => 'ressource',
            'objet_id'   => $resource->id,
            'action'     => 'state_change',
            'details'    => "Ressource désactivée par responsable : {$resource->nom}",
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Ressource désactivée.');
    }

    public function discussions()
    {
        $managedIds = Auth::user()->managedRessources()->pluck('id');
        $discussions = \App\Models\Discussion::whereIn('ressource_id', $managedIds)
            ->with(['ressource', 'messages.auteur'])
            ->latest()
            ->paginate(15);

        return view('responsable.discussions', compact('discussions'));
    }

    public function hideMessage(\App\Models\Message $message)
    {
        $this->checkDiscussionAccess($message->discussion);
        
        $message->update(['cache' => true]);

        \App\Models\Moderation::create([
            'message_id' => $message->id,
            'moderateur_id' => Auth::id(),
            'action' => 'hide',
            'raison' => 'Modéré par responsable technique'
        ]);

        \App\Models\Journal::create([
            'acteur_id'  => Auth::id(),
            'objet'      => 'message',
            'objet_id'   => $message->id,
            'action'     => 'moderate',
            'details'    => "Message #{$message->id} masqué par le responsable",
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Message masqué.');
    }

    private function checkDiscussionAccess(\App\Models\Discussion $discussion)
    {
        if ($discussion->ressource->manager_id !== Auth::id()) {
            abort(403);
        }
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
