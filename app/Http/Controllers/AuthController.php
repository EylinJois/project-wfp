<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Hardcoded testing accounts (no database required)
     * Password: password123 for all
     */
    private const HARDCODED_ACCOUNTS = [
        'admin@wfp.com' => [
            'password' => 'password123',
            'username' => 'admin',
        ],
        'member@wfp.com' => [
            'password' => 'password123',
            'username' => 'member',
        ],
        'dokter@wfp.com' => [
            'password' => 'password123',
            'username' => 'dokter',
        ],
    ];

    public function showLogin(Request $request): View|RedirectResponse
    {
        if (Auth::check() || $request->session()->has('hardcoded_auth')) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        if (Auth::check() || $request->session()->has('hardcoded_auth')) {
            return redirect('/');
        }

        $validated = $request->validate([
            'login' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'max:255'],
            'remember' => ['nullable', 'boolean'],
            'preset' => ['nullable', 'string'],
        ]);

        // Check if login is a hardcoded testing account
        if (isset(self::HARDCODED_ACCOUNTS[$validated['login']])) {
            $account = self::HARDCODED_ACCOUNTS[$validated['login']];
            if ($account['password'] === $validated['password']) {
                $request->session()->put('hardcoded_auth', [
                    'login' => $validated['login'],
                    'username' => $account['username'],
                    'is_admin' => $account['username'] === 'admin',
                ]);
                $request->session()->regenerate();

                // Store last login for remember-me
                if ($request->boolean('remember')) {
                    Cookie::queue(
                        'wfp_last_login',
                        $validated['login'],
                        60 * 24 * 30,
                        '/',
                        null,
                        false,
                        false
                    );
                }

                return redirect()->intended('/')->with('status', 'Login berhasil.');
            }
        }

        // Not a hardcoded account - check database
        $loginField = filter_var($validated['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginField => $validated['login'],
            'password' => $validated['password'],
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('login', 'remember'))
                ->withErrors([
                    'login' => 'Username/email atau password tidak cocok.',
                ]);
        }

        $request->session()->regenerate();

        // Store last login username/email for remember-me functionality
        if ($request->boolean('remember')) {
            Cookie::queue(
                'wfp_last_login',
                $validated['login'],
                60 * 24 * 30,
                '/',
                null,
                false,
                false
            );
        }

        return redirect()->intended('/')->with('status', 'Login berhasil.');
    }

    public function showRegister(Request $request): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:100', Rule::unique('user', 'username')],
            'email' => ['required', 'email', 'max:100', Rule::unique('user', 'email')],
            'nomor_telepon' => ['required', 'string', 'max:15', Rule::unique('user', 'nomor_telepon')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
            'member_id' => null,
            'dokter_id' => null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('status', 'Akun baru berhasil dibuat dan langsung login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        if (! Auth::check() && ! $request->session()->has('hardcoded_auth')) {
            return redirect()->route('login')->with('status', 'Anda sudah logout.');
        }

        Auth::logout();
        $request->session()->forget('hardcoded_auth');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda sudah logout.');
    }
}
