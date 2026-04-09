<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $data = Member::query()->orderBy('nama_lengkap')->get();

        return view('member', compact('data'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create member belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'foto' => ['required', 'string', 'max:255'],
        ]);

        Member::create($validated);

        return redirect()->route('member.index');
    }

    public function show(Member $member)
    {
        return response()->json(['data' => $member]);
    }

    public function edit(Member $member)
    {
        return response()->json(['data' => $member]);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'foto' => ['required', 'string', 'max:255'],
        ]);

        $member->update($validated);

        return redirect()->route('member.index');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('member.index');
    }
}