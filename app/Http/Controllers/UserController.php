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
        $users = User::query()
            ->orderByDesc('created_at')
            ->get();

        return view('user', compact('users'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create user belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:100', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:15', Rule::unique('users', 'phone_number')],
            'is_admin' => ['sometimes', 'boolean'],
            'member_id' => ['nullable', 'integer', 'exists:member,id'],
            'doctor_id' => ['nullable', 'integer', 'exists:doctor,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('user.index');
    }

    public function show(string $user)
    {
        return response()->json(['users' => $this->findUserByUsername($user)]);
    }

    public function edit(string $user)
    {
        return response()->json(['users' => $this->findUserByUsername($user)]);
    }

    public function update(Request $request, string $user)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:100', Rule::unique('users', 'username')->ignore($user, 'username')],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user, 'username')],
            'password' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:15', Rule::unique('users', 'phone_number')->ignore($user, 'username')],
            'is_admin' => ['sometimes', 'boolean'],
            'member_id' => ['nullable', 'integer', 'exists:member,id'],
            'doctor_id' => ['nullable', 'integer', 'exists:doctor,id'],
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

    public function storeAjax(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:100', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:15', Rule::unique('users', 'phone_number')],
            'is_admin' => ['sometimes', 'boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Simpan data ke database
        $user = User::create($validated);

        // Kirim respons JSON beserta data user yang baru dibuat
        return response()->json([
            'status' => 'oke',
            'users' => [
                'username'     => $user->username,
                'email'        => $user->email,
                'phone_number' => $user->phone_number,
                'is_admin'     => $user->is_admin,
                'member_id'    => $user->member_id,
                'doctor_id'    => $user->doctor_id,
                'created_at'   => $user->created_at->toDateTimeString(),
                'updated_at'   => $user->updated_at->toDateTimeString(),
            ]
        ]);
    }

    public function getEditForm(Request $request)
    {
        $user = User::findOrFail($request->username);
    
        return response()->json([
            'username'      => $user->username,
            'email'         => $user->email,
            'phone_number'  => $user->phone_number,
            'member_id'     => $user->member_id,
            'doctor_id'     => $user->doctor_id
        ]);
    }
    
    public function saveDataUpdate(Request $request)
    {
        $request->validate([
            'username'   => 'required',
            'email'      => 'required|email',
            'password'   => 'nullable|confirmed|min:6',
            'member_id'  => 'nullable|integer|exists:members,id',
            'doctor_id'  => 'nullable|integer|exists:doctors,id',
        ]);
    
        $user = User::where('username', $request->username)->first();
    
        if ($user) {
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->member_id = $request->filled('member_id') ? $request->member_id : null;
            $user->doctor_id = $request->filled('doctor_id') ? $request->doctor_id : null;
    
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
    
            $user->save();
    
            return response()->json([
                'status' => 'oke',
                'updated_at' => $user->updated_at->toDateTimeString()
            ]);
        }
    
        return response()->json([
            'status' => 'gagal',
            'msg' => 'User tidak ditemukan.'
        ]);
    }
    public function deleteData(Request $request)
    {
        // Cari user berdasarkan username yang dikirim AJAX
        $user = User::where('username', $request->username)->first();

        if ($user) {
            $user->delete(); // Hapus dari database

            return response()->json([
                'status' => 'oke'
            ]);
        }

        return response()->json([
            'status' => 'gagal',
            'msg' => 'User tidak ditemukan.'
        ]);
    }
}
