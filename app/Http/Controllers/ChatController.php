<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::with([
            'doctor',
            'member',
            'consultation',
        ])
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
            'chat' => 'required',
            'consultation_id' => 'required|integer|exists:consultations,id',
        ]);

        $consultation = Consultation::findOrFail($validated['consultation_id']);

        Chat::create([
            'chat' => $validated['chat'],
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
        $consultation->load([
            'doctor',
            'member',
            'chats',
        ]);

        if (auth()->user()->doctor_id) {
            return view('doctors.chat', compact('consultation'));
        }

        return view('members.chat', compact('consultation'));
    }

    public function edit(Chat $chat)
    {
        return response()->json(['chats' => $chat]);
    }

    public function update(Request $request, Chat $chat)
    {
        $validated = $request->validate([
            'chat' => ['required', 'string', 'max:255'],
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'consultation_id' => ['required', 'integer', 'exists:consultations,id'],
            'sender_role' => ['required', 'string', 'in:member,doctor'],
            'delivered_at' => ['required', 'date'],
        ]);

        $chat->update($validated);

        return back();
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();

        return back();
    }
}
