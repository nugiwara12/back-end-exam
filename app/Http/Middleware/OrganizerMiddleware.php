<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Allow both organizer and admin if needed
        if (!$user || !in_array($user->role, ['organizer', 'admin'])) {
            abort(403, 'Unauthorized: Organizers only');
        }

        return $next($request);
    }
}
