<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        if ($user->role != $role) {
            return redirect('dashboard')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}