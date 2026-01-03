<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user notifications
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Try to get real notifications if model exists
        try {
            if (class_exists(Notification::class)) {
                $notifications = $user->notifications()
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
            } else {
                $notifications = collect([]);
            }
        } catch (\Exception $e) {
            // Model not ready yet, use empty collection
            $notifications = collect([]);
        }

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        try {
            if (class_exists(Notification::class)) {
                /** @var User $user */
                $user = Auth::user();
                $notification = $user->notifications()->findOrFail($id);
                $notification->update(['lu' => true]);
                
                return back()->with('success', 'Notification marquée comme lue.');
            }
        } catch (\Exception $e) {
            // Notification model not ready
        }
        
        return back()->with('info', 'Fonctionnalité en cours de développement.');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        try {
            if (class_exists(Notification::class)) {
                /** @var User $user */
                $user = Auth::user();
                $user->notifications()
                    ->where('lu', false)
                    ->update(['lu' => true]); 
                
                return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
            }
        } catch (\Exception $e) {
            // Notification model not ready
        }
        
        return back()->with('info', 'Fonctionnalité en cours de développement.');
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        try {
            if (class_exists(Notification::class)) {
                /** @var User $user */
                $user = Auth::user();
                $notification = $user->notifications()->findOrFail($id);
                $notification->delete();
                
                return back()->with('success', 'Notification supprimée.');
            }
        } catch (\Exception $e) {
            // Notification model not ready
        }
        
        return back()->with('info', 'Fonctionnalité en cours de développement.');
    }
}