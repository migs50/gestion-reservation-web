<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = $user->role->nom ?? null;

        // CLÉ PASSE-PARTOUT : Si l'utilisateur est Admin, il a accès à TOUT
        if ($userRole === 'Admin') {
            return $next($request);
        }

        if (!in_array($userRole, $roles)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
