<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::query()
            ->with('specialty')
            ->orderBy('fullname')
            ->get();
        $specialties = \App\Models\Specialty::all();

        return view('doctors.index', compact('doctors', 'specialties'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create doctor belum tersedia.']);
    }

    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Doctor::find($id);
        $specialty = \App\Models\Specialty::all();
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('doctors.edit', compact('data', 'specialty'))->render()
        ), 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'fullname' => ['required', 'string', 'max:100'],
                'sip' => ['required', 'string', 'max:50', Rule::unique('doctors', 'sip')],
                'experience' => ['required', 'string', 'max:255'],
                'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
                'specialty_id' => ['required', 'integer', 'exists:specialties,id'],
                'start_time' => ['required', 'date_format:H:i'],
                'end_time' => ['required', 'date_format:H:i'],
            ]);

            unset($validated['photo']);

            $doctor = Doctor::create($validated);

            if ($request->hasFile('photo')) {

                $extension = $request->file('photo')->extension();

                $filename = 'd' . $doctor->id . '.' . $extension;

                $path = $request->file('photo')->storeAs(
                    'public/photos',
                    $filename
                );

                $doctor->photo = $filename;
                $doctor->save();
            }

            return redirect()->route('doctor.index', ['success' => 'Doctor created successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
        }
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
            'sip' => ['required', 'string', 'max:50', Rule::unique('doctors', 'sip')->ignore($doctor->id)],
            'experience' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:255'],
            'specialty_id' => ['required', 'integer', 'exists:specialties,id'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
        ]);

        $doctor->update($validated);

        return redirect()->route('doctor.index', ['success' => 'Doctor updated successfully.']);
    }

    public function deleteData(Request $request)
{
    try {

        $id = $request->id;

        $doctor = Doctor::findOrFail($id);

        if ($doctor->photo) {
            Storage::delete('public/photos/' . $doctor->photo);
        }

        $doctor->delete();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Doctor data is removed!'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => true,
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
        ], 500);
    }
}

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctor.index', ['success' => 'Doctor deleted successfully.']);
    }
}
