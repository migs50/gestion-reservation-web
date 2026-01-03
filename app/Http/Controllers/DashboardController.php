<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Ressource;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /** @var \App\Models\User $user */

        $user = Auth::user();

        // Common data for all roles
    
       $notifications = $this->getNotifications($user);

        // Role-specific dashboards
        if ($user->hasRole('Admin')) {
            return $this->adminDashboard($user, $notifications);
        } elseif ($user->hasRole('Responsable')) {
            return $this->responsableDashboard($user, $notifications);
        } else {
            return $this->userDashboard($user, $notifications);
        }
    }

    private function getNotifications($user)
    {

        try {
            if (method_exists($user, 'notifications')) {
                return $user->notifications()
                    ->where('lu', false)
                    ->latest()
                    ->limit(5)
                    ->get();
            }
        } catch (\Exception $e) {
            // Notification relationship not ready yet
        }
        
        return collect([]); // Return empty collection
    }

    private function userDashboard($user, $notifications)
    {
        $stats = [
            'total_reservations' => $user->reservations()->count(),
            'pending' => $user->reservations()->where('statut', 'pending')->count(),
            'approved' => $user->reservations()->where('statut', 'approved')->count(),
            'active' => $user->reservations()->where('statut', 'active')->count(),
        ];

        $recent_reservations = $user->reservations()
            ->latest()
            ->limit(5)
            ->get();

        $available_ressources = Ressource::where('actif', true)
            ->where('etat', 'available')
            ->count();

        return view('dashboard.user', compact('stats', 'recent_reservations', 'notifications', 'available_ressources'));
    }

    private function responsableDashboard($user, $notifications)
    {
        $managed_ressources = $user->managedRessources()->count();
        $pending_requests = Reservation::whereHas('affectations', function($query) use ($user) {
            $query->whereHas('ressource', function($q) use ($user) {
                $q->where('manager_id', $user->id);
            });
        })->where('statut', 'pending')->count();

        $recent_requests = Reservation::whereHas('affectations', function($query) use ($user) {
            $query->whereHas('ressource', function($q) use ($user) {
                $q->where('manager_id', $user->id);
            });
        })->latest()->limit(5)->get();

        return view('dashboard.responsable', compact('managed_ressources', 'pending_requests', 'recent_requests', 'notifications'));
    }

    private function adminDashboard($user, $notifications)
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_ressources' => Ressource::count(),
            'active_reservations' => Reservation::where('statut', 'active')->count(),
            'pending_requests' => Reservation::where('statut', 'pending')->count(),
        ];

        $recent_activity = \App\Models\Journal::with('acteur')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.admin', compact('stats', 'recent_activity', 'notifications'));
    }
}
