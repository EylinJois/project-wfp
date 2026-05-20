<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::query()
            ->orderBy('fullname')
            ->get();

        return view('doctor', compact('doctors'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create doctor belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:100'],
            'sip' => ['required', 'string', 'max:50', Rule::unique('doctors', 'sip')],
            'experience' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:255'],
            'specialty_id' => ['required', 'integer', 'exists:spesialisasi,id'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
        ]);

        Doctor::create($validated);
        return redirect()->route('doctor.index');
    }

    public function show(Doctor $doctor)
    {
        return response()->json(['doctors' => $doctor]);
    }

    public function edit(Doctor $doctor)
    {
        return response()->json(['doctors' => $doctor]);
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:100'],
            'sip' => ['required', 'string', 'max:50', Rule::unique('doctor', 'sip')->ignore($doctor->id)],
            'experience' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:255'],
            'specialty_id' => ['required', 'integer', 'exists:specialty,id'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
        ]);

        $doctor->update($validated);

        return redirect()->route('doctor.index');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctor.index');
    }
}