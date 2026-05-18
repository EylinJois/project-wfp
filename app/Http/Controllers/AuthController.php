<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if (Auth::check() || $request->session()->has('hardcoded_auth')) {
            return redirect('/');
        }

        return view('auth.login');
    }

    // TODO: Pastikan error ditampilkan (password/username salah)
    public function login(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/');
        }
    
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
    
        $user = \App\Models\User::where('username', $validated['username'])->first();
    
        if (!$user) {
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
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        \App\Models\User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
            'member_id' => null,
            'dokter_id' => null
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



