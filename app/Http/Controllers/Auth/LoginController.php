<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt(['username' => $validated['username'], 'password' => $validated['password']])) {
            return back()->with('error', 'Invalid username or password.')->withInput($request->only('username'));
        }

        $user = Auth::user();

        if (!$user->hasActiveSubscription()) {
            return redirect()->route('subscription.show')
                ->with('error', 'Your subscription has expired. Please renew.');
        }

        $request->session()->regenerate();

        return redirect()->route('home.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
