<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::query()
            ->orderByDesc('delivered_at')
            ->get();

        return view('chat', compact('chats'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create chat belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'chat' => ['required', 'string', 'max:255'],
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'doctor' => ['required', 'integer', 'exists:doctors,id'],
            'consultation' => ['required', 'integer', 'exists:consultations,id'],
            'delivered_at' => ['required', 'date'],
        ]);

        Chat::create($validated);

        return redirect()->route('chat.index');
    }

    public function show(Chat $chat)
    {
        return response()->json(['chats' => $chat]);
    }

    public function edit(Chat $chat)
    {
        return response()->json(['chats' => $chat]);
    }

    public function update(Request $request, Chat $chat)
    {
        $validated = $request->validate([
            'chat' => ['required', 'string', 'max:255'],
            'member_id' => ['required', 'integer', 'exists:member,id'],
            'doctor' => ['required', 'integer', 'exists:dokter,id'],
            'consultation' => ['required', 'integer', 'exists:konsultasi,id'],
            'delivered_at' => ['required', 'date'],
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