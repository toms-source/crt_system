<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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
        // return view('auth.login');
        return view('welcome');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        //$request = User::with('roles');

        
        $user = $request->user();
        
        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.index', absolute: false));
        }
        elseif($user->hasRole('manager')) {
            return redirect()->intended(route('manager.index', absolute: false));
        }
        elseif($user->hasRole('user')) {
            return redirect()->intended(route('user.index', absolute: false));
        }
        else
        {
            return redirect()->intended(route('/', absolute: false));
        }
        
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
