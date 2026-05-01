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
     * All use password: password123
     * Roles: Admin, Member (Margason/Megan), Dokter (Elly)
     */

    private const REGISTER_PRESETS = [
        'admin' => [
            'label' => 'Template Admin',
            'username' => 'testadmin',
            'email' => 'testadmin@wfp.com',
            'password' => 'password123',
            'nomor_telepon' => '085200000101',
        ],
        'member' => [
            'label' => 'Template Member',
            'username' => 'testmember',
            'email' => 'testmember@wfp.com',
            'password' => 'password123',
            'nomor_telepon' => '085200000102',
        ],
        'dokter' => [
            'label' => 'Template Dokter',
            'username' => 'testdokter',
            'email' => 'testdokter@wfp.com',
            'password' => 'password123',
            'nomor_telepon' => '085200000103',
        ],
    ];

    public function showLogin(Request $request): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'max:255'],
            'remember' => ['nullable', 'boolean'],
            'preset' => ['nullable', 'string'],
        ]);

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

        // Store last login username/email for remember-me functionality (accessible from JavaScript)
        if ($request->boolean('remember')) {
            Cookie::queue(
                'wfp_last_login',
                $validated['login'],
                60 * 24 * 30,  // 30 days
                '/',           // path
                null,          // domain
                false,         // secure (set false for HTTP, true for HTTPS only)
                false          // httpOnly: false so JavaScript can access it
            );
        }

        return redirect()->intended('/')->with('status', 'Login berhasil.');
    }

    public function showRegister(Request $request): View
    {
        $defaultKey = array_key_first(self::REGISTER_PRESETS);
        $selectedPreset = $request->cookie('wfp_register_preset', $defaultKey);
        $selectedPreset = array_key_exists($selectedPreset, self::REGISTER_PRESETS) ? $selectedPreset : $defaultKey;

        return view('auth.register', [
            'presets' => self::REGISTER_PRESETS,
            'selectedPreset' => $selectedPreset,
            'prefill' => self::REGISTER_PRESETS[$selectedPreset],
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'preset' => ['nullable', 'string'],
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

        Cookie::queue(cookie('wfp_register_preset', $request->input('preset', 'member'), 60 * 24 * 30));
        Cookie::queue(cookie('wfp_last_registered_username', $validated['username'], 60 * 24 * 30));

        return redirect('/')->with('status', 'Akun baru berhasil dibuat dan langsung login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda sudah logout.');
    }
}
