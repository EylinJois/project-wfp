<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::query()->orderBy('fullname')->get();

        return view('member', compact('members'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create member belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:100'],
            'birth_of_date' => ['required', 'date'],
            'photo' => ['required', 'string', 'max:255'],
        ]);

        Member::create($validated);

        return redirect()->route('member.index');
    }

    public function show(Member $member)
    {
        return response()->json(['members' => $member]);
    }

    public function edit(Member $member)
    {
        return response()->json(['members' => $member]);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:100'],
            'birth_of_date' => ['required', 'date'],
            'photo' => ['required', 'string', 'max:255'],
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