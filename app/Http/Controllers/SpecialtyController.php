<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::query()->orderBy('name')->get();
        return view('specialty', compact('specialties'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create specialty belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        Specialty::create($validated);

        return redirect()->route('specialty.index');
    }

    public function show(Specialty $specialty)
    {
        return response()->json(['specialties' => $specialty]);
    }

    public function edit(Specialty $specialty)
    {
        return response()->json(['specialties' => $specialty]);
    }

    public function update(Request $request, Specialty $specialty)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $specialty->update($validated);

        return redirect()->route('specialty.index');
    }

    public function destroy(Specialty $specialty)
    {
        $specialty->delete();

        return redirect()->route('specialty.index');
    }
}