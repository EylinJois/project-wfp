<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $data = User::query()
            ->orderByDesc('created_at')
            ->get();

        return view('user', compact('data'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create user belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:100', Rule::unique('user', 'username')],
            'email' => ['required', 'email', 'max:100', Rule::unique('user', 'email')],
            'password' => ['required', 'string', 'max:255'],
            'nomor_telepon' => ['required', 'string', 'max:15', Rule::unique('user', 'nomor_telepon')],
            'is_admin' => ['sometimes', 'boolean'],
            'member_id' => ['nullable', 'integer', 'exists:member,id'],
            'dokter_id' => ['nullable', 'integer', 'exists:dokter,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('user.index');
    }

    public function show(string $user)
    {
        return response()->json(['data' => $this->findUserByUsername($user)]);
    }

    public function edit(string $user)
    {
        return response()->json(['data' => $this->findUserByUsername($user)]);
    }

    public function update(Request $request, string $user)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:100', Rule::unique('user', 'username')->ignore($user, 'username')],
            'email' => ['required', 'email', 'max:100', Rule::unique('user', 'email')->ignore($user, 'username')],
            'password' => ['nullable', 'string', 'max:255'],
            'nomor_telepon' => ['required', 'string', 'max:15', Rule::unique('user', 'nomor_telepon')->ignore($user, 'username')],
            'is_admin' => ['sometimes', 'boolean'],
            'member_id' => ['nullable', 'integer', 'exists:member,id'],
            'dokter_id' => ['nullable', 'integer', 'exists:dokter,id'],
        ]);

        if (! isset($validated['password']) || $validated['password'] === null || $validated['password'] === '') {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        User::query()->where('username', $user)->update($validated);

        return redirect()->route('user.index');
    }

    public function destroy(string $user)
    {
        $this->findUserByUsername($user)->delete();

        return redirect()->route('user.index');
    }

    private function findUserByUsername(string $username): User
    {
        return User::query()->where('username', $username)->firstOrFail();
    }
}
