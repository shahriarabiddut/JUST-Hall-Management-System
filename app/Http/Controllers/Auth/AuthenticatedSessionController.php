<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
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
    public function create2(): View
    {
        return view('auth.login2');
    }
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
    public function store2(LoginRequest $request): RedirectResponse
    {
        $request->authenticate2();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
    public function store3(LoginRequest $request): RedirectResponse
    {
        if (filter_var($request->email2, FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                'email' => $request->email2, // Assuming email2 is the field name in the form
                'password' => $request->password,
            ];
            $request->authenticate3($credentials);
        } else {
            $request->authenticate2();
        }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
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
