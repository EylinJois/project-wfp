<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // $chats = Chat::query()
        //     ->orderByDesc('delivered_at')
        //     ->get();

        // return view('chat', compact('chats'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create chat belum tersedia.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'chat' => 'required',
            'consultation_id' => 'required|exists:consultations,id',
        ]);

        $consultation = Consultation::findOrFail($request->consultation_id);

        Chat::create([
            'chat' => $request->chat,
            'consultation_id' => $consultation->id,
            'doctor_id' => $consultation->doctor_id,
            'member_id' => $consultation->member_id,
            'sender_role' => auth()->user()->role,
            'delivered_at' => now(),
        ]);

        return back();
    }

    public function show(Consultation $consultation)
    {
        // // return response()->json(['chats' => $chat]);

        $consultation->load([
            'doctor',
            'member',
            'chats',
        ]);

        return view(
            'members.chat',
            compact('consultation')
        );
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
