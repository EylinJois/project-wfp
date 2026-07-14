<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if (Auth::check() || $request->session()->has('hardcoded_auth')) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $validated['username'])->first();

        if (! $user) {
            return back()->withErrors([
                'username' => 'Username not found.',
            ])->withInput();
        }

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->intended('/')->with('status', 'Welcome back!');
        }

        return back()->withErrors([
            'password' => 'Incorrect password!',
        ])->withInput();
    }

    public function showRegister(Request $request): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 'member',
            'member_id' => null,
            'doctor_id' => null,
        ]);

        return redirect('/auth/login')->with('status', 'Registration successful! Please sign in.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login')->with('status', 'Sign out success!');
    }
}
