<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::query()
            ->with('specialty')
            ->orderBy('fullname')
            ->get();
        $specialties = Specialty::all();

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
        $specialty = Specialty::all();

        return response()->json([
            'status' => 'oke',
            'msg' => view('doctors.edit', compact('data', 'specialty'))->render(),
        ], 200);
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

                $filename = 'd'.$doctor->id.'.'.$extension;

                $path = $request->file('photo')->storeAs(
                    'public/photos',
                    $filename
                );

                $doctor->photo = $filename;
                $doctor->save();
            }

            return redirect()
                ->route('doctor.index')
                ->with('success', 'Doctor created successfully.');
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
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return response()->json(['doctors' => $doctor]);
    }

    public function editProfile()
    {
        $user = auth()->user();
        $doctor = $user->doctor_id ? Doctor::find($user->doctor_id) : null;

        if (! $doctor) {
            abort(403, 'Unauthorized action. You don\'t have access to this page!');
        }

        $specialties = Specialty::all();

        return view('doctors.editProfile', compact('doctor', 'specialties'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:100'],
            'sip' => ['required', 'string', 'max:50', Rule::unique('doctors', 'sip')->ignore($doctor->id)],
            'experience' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
            'specialty_id' => ['required', 'integer', 'exists:specialties,id'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
        ]);

        $doctor->fullname = $validated['fullname'];
        $doctor->sip = $validated['sip'];
        $doctor->experience = $validated['experience'];
        $doctor->specialty_id = $validated['specialty_id'];
        $doctor->start_time = $validated['start_time'];
        $doctor->end_time = $validated['end_time'];

        if ($request->hasFile('photo')) {

            if ($doctor->photo) {
                Storage::delete('public/photos/'.$doctor->photo);
            }

            $extension = $request->file('photo')->extension();
            $filename = 'd'.$doctor->id.'.'.$extension;

            $request->file('photo')->storeAs(
                'public/photos',
                $filename
            );

            $doctor->photo = $filename;
        }

        $doctor->save();

        return redirect()
            ->route('doctor.index')
            ->with('success', 'Doctor data updated successfully.');
    }

    public function updateProfile(Request $request)
    {
        $doctor = Doctor::findOrFail(auth()->user()->doctor_id);

        $request->validate([
            'fullname' => ['required', 'string', 'max:100'],
            'sip' => [
                'required',
                'string',
                'max:50',
                Rule::unique('doctors', 'sip')->ignore($doctor->id),
            ],
            'experience' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
            'specialty_id' => ['required', 'integer', 'exists:specialties,id'],
            'start_time' => ['required'],
            'end_time' => ['required'],
        ]);

        $doctor->fullname = $request->fullname;
        $doctor->sip = $request->sip;
        $doctor->experience = $request->experience;
        $doctor->specialty_id = $request->specialty_id;
        $doctor->start_time = $request->start_time;
        $doctor->end_time = $request->end_time;

        if ($request->hasFile('photo')) {

            if ($doctor->photo) {
                Storage::delete('public/photos/'.$doctor->photo);
            }

            $extension = $request->photo->extension();

            $filename = 'd'.$doctor->id.'.'.$extension;

            $request->photo->storeAs(
                'public/photos',
                $filename
            );

            $doctor->photo = $filename;
        }

        $doctor->save();

        return redirect()
            ->route('doctor.editProfile')
            ->with('success', 'Your profile has been updated successfully.');
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;

        $data = Doctor::findOrFail($id);

        $data->fullname = $request->fullname;
        $data->sip = $request->sip;
        $data->experience = $request->experience;
        $data->specialty_id = $request->specialty_id;
        $data->start_time = $request->start_time;
        $data->end_time = $request->end_time;

        if ($request->photo) {

            // delete old photo
            if ($data->photo) {
                Storage::delete('public/photos/'.$data->photo);
            }

            $extension = $request->file('photo')->extension();

            $filename = 'd'.$data->id.'.'.$extension;

            // save new photo
            $request->file('photo')->storeAs(
                'public/photos',
                $filename
            );

            // save filename to database
            $data->photo = $filename;
        }

        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'doctor data is up-to-date !',
            'specialty_name' => $data->specialty->name,
            'photo' => $data->photo,
            'photo_url' => asset('storage/photos/'.$data->photo),
        ], 200);
    }

    public function deleteData(Request $request)
    {
        try {

            $id = $request->id;

            $doctor = Doctor::findOrFail($id);

            if ($doctor->photo) {
                Storage::delete('public/photos/'.$doctor->photo);
            }

            $doctor->delete();

            return response()->json([
                'status' => 'oke',
                'msg' => 'Doctor data is removed!',
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

        return redirect()
            ->route('doctor.index')
            ->with('success', 'Doctor deleted successfully.');
    }
}
