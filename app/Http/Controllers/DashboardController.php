<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Ressource;
use App\Models\DemandeCompte;

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
        } elseif ($user->hasRole('Responsable Technique')) {
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
            'total'      => $user->reservations()->count(),
            'en_attente' => $user->reservations()->where('statut', 'pending')->count(),
            'actives'    => $user->reservations()->whereIn('statut', ['approved', 'active'])->count(),
        ];
        // Removed separate 'approuvees' key as per user preference

        $recent_reservations = $user->reservations()
            ->latest()
            ->limit(5)
            ->get();

        $available_ressources = Ressource::where('actif', true)
            ->where('etat', 'available')
            ->count();

        // Activity data for chart (last 7 days)
        $activity = $user->reservations()
            ->selectRaw('DATE(debut) as date, COUNT(*) as total')
            ->where('debut', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $activity_data = [
            'labels' => [],
            'values' => []
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d/m');
            $activity_data['labels'][] = $label;
            
            $match = $activity->firstWhere('date', $date);
            $activity_data['values'][] = $match ? $match->total : 0;
        }

        return view('dashboard.user', compact('stats', 'recent_reservations', 'notifications', 'available_ressources', 'activity_data'));
    }

    private function responsableDashboard($user, $notifications)
    {
        $managedRessources = $user->managedRessources();
        $totalResources = $managedRessources->count();
        
        $pendingRequestsQuery = Reservation::whereIn('ressource_id', $managedRessources->pluck('id'))
            ->where('statut', 'pending');
            
        $pendingRequests = $pendingRequestsQuery->count();
        $requests = $pendingRequestsQuery->with(['demandeur', 'ressource'])->latest()->limit(5)->get();
        
        $approvedReservations = Reservation::whereIn('ressource_id', $managedRessources->pluck('id'))
            ->whereIn('statut', ['approved', 'active'])
            ->count();

        // Grouping for overview
        $resourcesByType = $managedRessources->with('categorie')
            ->get()
            ->groupBy(function($r) {
                return $r->categorie->nom ?? 'Autre';
            })->map(function($group) {
                $total = $group->count();
                $occupied = $group->where('etat', 'occupied')->count();
                return [
                    'total' => $total,
                    'occupied' => $occupied,
                    'percentage' => $total > 0 ? round(($occupied / $total) * 100) : 0
                ];
            });

        // Dummy trends to avoid errors (would need historical data for real logic)
        $resourceTrend = 0;
        $requestTrend = 0;
        $approvedTrend = 0;
        $activeAlerts = 0;
        $alertTrend = 0;

        return view('dashboard.responsable', compact(
            'totalResources', 
            'pendingRequests', 
            'approvedReservations', 
            'requests', 
            'resourcesByType', 
            'notifications',
            'resourceTrend',
            'requestTrend',
            'approvedTrend',
            'activeAlerts',
            'alertTrend'
        ));
    }

    private function adminDashboard($user, $notifications)
    {
        $users = \App\Models\User::all();
        $stats = [
            'total_users' => $users->count(),
            'total_ressources' => Ressource::count(),
            'active_reservations' => Reservation::where('statut', 'active')->count(),
            'pending_requests' => DemandeCompte::where('statut', 'pending')->count(),
            'users' => $users,
        ];

        $recent_activity = \App\Models\Journal::with('acteur')
            ->latest()
            ->limit(10)
            ->get();
        $recent_reservations = Reservation::with(['demandeur', 'ressource'])
            ->orderBy('debut', 'desc')
            ->limit(5)
            ->get();
            
        $activity_data = [
            'days'   => ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            'values' => [12, 19, 15, 25, 22, 18, 20],
        ];

        return view('dashboard.admin', compact(
            'stats',
            'recent_activity',
            'notifications',
            'activity_data',
            'recent_reservations'
        ));


        
    }
    public function user()
{
    // logique spécifique user
    return view('dashboard.user');
}

}
