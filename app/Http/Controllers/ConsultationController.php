<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::query()
            ->orderByDesc('time')
            ->get();

        return view('consultation', compact('consultations'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create consultation belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'time' => ['required', 'date'],
            'status' => ['required', 'string', 'max:20'],
            'consultation_type' => ['required', Rule::in(['none', 'ongoing', 'done'])],
            'notes' => ['nullable', 'string'],
            'member_id' => ['required', 'integer', 'exists:member,id'],
            'doctor' => ['required', 'integer', 'exists:doctor,id'],
        ]);

        Consultation::create($validated);

        return redirect()->route('consultation.index');
    }

    public function show(Consultation $consultation)
    {
        return response()->json(['consultation' => $consultation]);
    }

    public function edit(Consultation $consultation)
    {
        return response()->json(['consultation' => $consultation]);
    }

    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'time' => ['required', 'date'],
            'status' => ['required', 'string', 'max:20'],
            'consultation_type' => ['required', Rule::in(['kosong', 'sedang berlangsung', 'selesai'])],
            'notes' => ['nullable', 'string'],
            'member_id' => ['required', 'integer', 'exists:member,id'],
            'doctor' => ['required', 'integer', 'exists:dokter,id'],
        ]);

        $consultation->update($validated);

        return redirect()->route('consultation.index');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('consultation.index');
    }
}
