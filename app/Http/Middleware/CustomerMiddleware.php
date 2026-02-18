<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Allow both 'customer' and 'admin'
        if (!$user || !in_array($user->role, ['customer', 'admin'])) {
            abort(403, 'Unauthorized: Customers only');
        }

        return $next($request);
    }
}

