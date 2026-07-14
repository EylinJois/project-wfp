<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'fullname' => 'required',
            'email' => 'required|email|unique:members,email',
            'phone_number' => 'required|unique:members,phone_number',
            'birth_of_date' => 'required',
            'photo' => 'required']);

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

    public function storeAjax(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:100',
            'email' => 'required|email|unique:members,email',
            'phone_number' => 'required|unique:members,phone_number',
            'birth_of_date' => 'required|date',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('photo')->store('members', 'public');

        $member = Member::create([
            'fullname' => $request->fullname,
            'birth_of_date' => $request->birth_of_date,
            'photo' => $path,
        ]);

        return response()->json([
            'status' => 'oke',
            'member' => [
                'id' => $member->id,
                'fullname' => $member->fullname,
                'birth_of_date' => $member->birth_of_date,
                'photo_url' => Storage::url($member->photo),
                'created_at' => $member->created_at->toDateTimeString(),
                'updated_at' => $member->updated_at->toDateTimeString(),
            ],
        ]);
    }

    public function getEditForm(Request $request)
    {
        $member = Member::findOrFail($request->id);

        return response()->json([
            'id' => $member->id,
            'fullname' => $member->fullname,
            'birth_of_date' => $member->birth_of_date,
            'photo_url' => $member->photo ? Storage::url($member->photo) : null,
        ]);
    }

    public function saveDataUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:members,id',
            'fullname' => 'required|string|max:100',
            'email' => 'required|email|unique:members,email,' . $request->id,
            'phone_number' => 'required|unique:members,phone_number,' . $request->id,
            'birth_of_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $member = Member::find($request->id);

        if ($member) {
            $member->fullname = $request->fullname;
            $member->birth_of_date = $request->birth_of_date;

            if ($request->hasFile('photo')) {
                if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                    Storage::disk('public')->delete($member->photo);
                }
                $member->photo = $request->file('photo')->store('members', 'public');
            }

            $member->save();

            return response()->json([
                'status' => 'oke',
                'fullname' => $member->fullname,
                'birth_of_date' => $member->birth_of_date,
                'photo_url' => Storage::url($member->photo),
                'updated_at' => $member->updated_at->toDateTimeString(),
            ]);
        }

        return response()->json([
            'status' => 'gagal',
            'msg' => 'Member tidak ditemukan.',
        ]);
    }

    public function deleteData(Request $request)
    {
        $member = Member::find($request->id);

        if ($member) {
            if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                Storage::disk('public')->delete($member->photo);
            }

            $member->delete();

            return response()->json(['status' => 'oke']);
        }

        return response()->json([
            'status' => 'gagal',
            'msg' => 'Member tidak ditemukan.',
        ]);
    }
}
