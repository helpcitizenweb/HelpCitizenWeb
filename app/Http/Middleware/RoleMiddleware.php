<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is logged in and has the correct role
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);
        }

        // If not authorized, abort with a 403 response
        abort(403, 'Unauthorized access');
    }
}

