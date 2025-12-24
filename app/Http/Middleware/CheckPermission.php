<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user has the required permission through their role
        $hasPermission = $user->role->permissions()
            ->where('nom', $permission)
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Vous n\'avez pas la permission pour effectuer cette action.');
        }

        return $next($request);
    }
}
