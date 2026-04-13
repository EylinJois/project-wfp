<?php

namespace App\Http\Controllers;

use App\Models\Spesialisasi;
use Illuminate\Http\Request;

class SpesialisasiController extends Controller
{
    public function index()
    {
        $data = Spesialisasi::query()->orderBy('nama')->get();

        return view('spesialisasi', compact('data'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create spesialisasi belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
        ]);

        Spesialisasi::create($validated);

        return redirect()->route('spesialisasi.index');
    }

    public function show(Spesialisasi $spesialisasi)
    {
        return response()->json(['data' => $spesialisasi]);
    }

    public function edit(Spesialisasi $spesialisasi)
    {
        return response()->json(['data' => $spesialisasi]);
    }

    public function update(Request $request, Spesialisasi $spesialisasi)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
        ]);

        $spesialisasi->update($validated);

        return redirect()->route('spesialisasi.index');
    }

    public function destroy(Spesialisasi $spesialisasi)
    {
        $spesialisasi->delete();

        return redirect()->route('spesialisasi.index');
    }
}