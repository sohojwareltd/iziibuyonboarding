<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the admin login page.
     */
    public function showLogin()
    {
        // Redirect to onboarding index if already authenticated
        if (Auth::check() && (int) Auth::user()->role_id === 1) {
            return redirect()->route('admin.onboarding.index');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = $request->user();
            if ((int) $user->role_id !== 1) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You are not authorized to access admin.'
                ])->onlyInput('email');
            }

            return redirect()->route('admin.onboarding.index');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

