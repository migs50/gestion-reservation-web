<?php

namespace App\Http\Controllers;

use App\Models\Ressource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\ReservationCreated;
use App\Notifications\NewReservationRequest;
use App\Notifications\ReservationCancelled;
use App\Notifications\IssueReported;
use App\Models\SupportTicket;



class UserController extends Controller
{
    /**
     * Afficher le tableau de bord utilisateur
     */
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        $ressources = Ressource::all();

        // Récupérer les ressources disponibles
        $resources = Ressource::with('specifications')
            ->where('status', 'available')
            ->orWhere('status', 'maintenance')
            ->get()
            ->map(function ($resource) {
                $resource->icon = $this->getResourceIcon($resource->category);
                $resource->status_color = $this->getStatusColor($resource->status);
                return $resource;
            });

        // Récupérer les réservations de l'utilisateur
        $reservations = Reservation::with('resource')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'active'])
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($reservation) {
                $reservation->status_label = $this->getStatusLabel($reservation->status);
                $reservation->status_color = $this->getStatusColor($reservation->status);
                return $reservation;
            });

        // Récupérer l'historique
        $history = Reservation::with('resource')
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'rejected'])
            ->orderBy('end_date', 'desc')
            ->paginate(10);

        $history->getCollection()->transform(function ($item) {
            $item->status_label = $this->getStatusLabel($item->status);
            $item->status_color = $this->getStatusColor($item->status);
            return $item;
        });

        // Récupérer les notifications récentes
        $notifications = $user->notifications()
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->data['message'] ?? '',
                    'type' => $notification->data['type'] ?? 'info',
                    'icon' => $this->getNotificationIcon($notification->data['type'] ?? 'info'),
                    'time' => $notification->created_at->diffForHumans(),
                ];
            });

        // Ressources disponibles pour le formulaire de réservation
        $availableResources = Ressource::where('status', 'available')->get();

        return view('user.dashboard', compact(
            'resources',
            'reservations',
            'history',
            'notifications',
            'availableResources'
        ));
    }

    /**
     * Créer une nouvelle réservation
     */
    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'justification' => 'required|string|min:20|max:1000',
        ], [
            'resource_id.required' => 'Veuillez sélectionner une ressource.',
            'resource_id.exists' => 'La ressource sélectionnée n\'existe pas.',
            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.after_or_equal' => 'La date de début doit être aujourd\'hui ou ultérieure.',
            'end_date.required' => 'La date de fin est obligatoire.',
            'end_date.after' => 'La date de fin doit être après la date de début.',
            'justification.required' => 'La justification est obligatoire.',
            'justification.min' => 'La justification doit contenir au moins 20 caractères.',
            'justification.max' => 'La justification ne peut pas dépasser 1000 caractères.',
        ]);

        // Vérifier la disponibilité de la ressource

        $resource = Ressource::findOrFail($validated['resource_id']);
        
        if ($resource->status !== 'available') {
            return back()->with('error', 'Cette ressource n\'est pas disponible pour le moment.');
        }

        // Vérifier les conflits de réservation
        $conflict = Reservation::where('resource_id', $validated['resource_id'])
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                          ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Cette ressource est déjà réservée pour la période sélectionnée.');
        }

        // Créer la réservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $validated['resource_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'justification' => $validated['justification'],
            'status' => 'pending',
        ]);

        // Créer une notification
        
         /** @var User $user */
        $user = Auth::user();
        $user->notify(new ReservationCreated($reservation));

        // Notifier les administrateurs
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewReservationRequest($reservation, $user));
        }

        return redirect()->route('dashboard.user')
            ->with('success', 'Votre demande de réservation a été soumise avec succès. Vous serez notifié une fois qu\'elle sera traitée.');
    }

    /**
     * Annuler une réservation
     */
    public function cancelReservation($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->firstOrFail();

        $reservation->update(['status' => 'cancelled']);

        // Notification
        
/** @var User $user */
$user = Auth::user();

$user->notify(new ReservationCancelled($reservation));
       
        return response()->json([
            'success' => true,
            'message' => 'Réservation annulée avec succès.',
        ]);
    }

    /**
     * Signaler un problème
     */
    public function reportIssue($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        // Créer un ticket de support
           SupportTicket::create([
            'reservation_id' => $reservation->id,
            'user_id' => Auth::id(),
            'subject' => 'Problème avec la réservation #' . $reservation->id,
            'description' => 'L\'utilisateur a signalé un problème technique.',
            'status' => 'open',
            'priority' => 'high',
        ]);

        // Notifier les administrateurs
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new IssueReported($reservation, Auth::user()));
        }

        return response()->json([
            'success' => true,
            'message' => 'Le problème a été signalé. Un administrateur vous contactera bientôt.',
        ]);
    }

    /**
     * Afficher l'historique avec filtres
     */
    public function history(Request $request)
    {
        $query = Reservation::with('resource')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['completed', 'cancelled', 'rejected']);

        // Filtres
        if ($request->filled('date_start')) {
            $query->where('start_date', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->where('end_date', '<=', $request->date_end);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->whereHas('resource', function ($q) use ($request) {
                $q->where('category', $request->type);
            });
        }

        $history = $query->orderBy('end_date', 'desc')->paginate(15);

        $history->getCollection()->transform(function ($item) {
            $item->status_label = $this->getStatusLabel($item->status);
            $item->status_color = $this->getStatusColor($item->status);
            return $item;
        });

        return view('user.history', compact('history'));
    }

    /**
     * Helpers
     */
    private function getResourceIcon($category)
    {
        return match ($category) {
            'physical' => 'server',
            'virtual' => 'cloud',
            'storage' => 'hdd',
            'network' => 'wifi',
            default => 'server',
        };
    }

    private function getStatusLabel($status)
    {
        return match ($status) {
            'pending' => 'En attente',
            'approved' => 'Approuvée',
            'active' => 'Active',
            'completed' => 'Terminée',
            'cancelled' => 'Annulée',
            'rejected' => 'Refusée',
            default => ucfirst($status),
        };
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'active' => 'success',
            'approved' => 'blue',
            'pending' => 'yellow',
            'rejected', 'cancelled' => 'danger',
            'completed' => 'gray',
            'available' => 'success',
            'maintenance' => 'warning',
            'occupied' => 'danger',
            default => 'secondary',
        };
    }

    private function getNotificationIcon($type)
    {
        return match ($type) {
            'success' => 'check-circle-fill',
            'warning' => 'exclamation-triangle-fill',
            'error' => 'x-circle-fill',
            default => 'info-circle-fill',
        };
    }
}