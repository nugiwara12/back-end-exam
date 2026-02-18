<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the logged-in user
        $user = Auth::user();

        // Create a Sanctum token
        $token = $user->createToken('web_login_token')->plainTextToken;

        // Optional: store the token in the session so you can use it in API calls from the web
        session(['sanctum_token' => $token]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Delete all tokens for this user (removes them completely)
        if ($user) {
            $user->tokens()->delete();
        }

        // Logout from web session
        Auth::guard('web')->logout();

        // Invalidate and regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
