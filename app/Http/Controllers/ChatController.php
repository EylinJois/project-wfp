<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $data = Chat::query()
            ->orderByDesc('waktu_kirim')
            ->get();

        return view('chat', compact('data'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create chat belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pesan' => ['required', 'string', 'max:255'],
            'member_id' => ['required', 'integer', 'exists:member,id'],
            'dokter_id' => ['required', 'integer', 'exists:dokter,id'],
            'konsultasi_id' => ['required', 'integer', 'exists:konsultasi,id'],
            'waktu_kirim' => ['required', 'date'],
        ]);

        Chat::create($validated);

        return redirect()->route('chat.index');
    }

    public function show(Chat $chat)
    {
        return response()->json(['data' => $chat]);
    }

    public function edit(Chat $chat)
    {
        return response()->json(['data' => $chat]);
    }

    public function update(Request $request, Chat $chat)
    {
        $validated = $request->validate([
            'pesan' => ['required', 'string', 'max:255'],
            'member_id' => ['required', 'integer', 'exists:member,id'],
            'dokter_id' => ['required', 'integer', 'exists:dokter,id'],
            'konsultasi_id' => ['required', 'integer', 'exists:konsultasi,id'],
            'waktu_kirim' => ['required', 'date'],
        ]);

        $chat->update($validated);

        return redirect()->route('chat.index');
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();

        return redirect()->route('chat.index');
    }
}