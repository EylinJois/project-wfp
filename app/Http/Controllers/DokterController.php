<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DokterController extends Controller
{
    public function index()
    {
        $data = Dokter::query()
            ->orderBy('nama_lengkap')
            ->get();

        return view('dokter', compact('data'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create dokter belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'sip' => ['required', 'string', 'max:50', Rule::unique('dokter', 'sip')],
            'pengalaman' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'string', 'max:255'],
            'spesialisasi_id' => ['required', 'integer', 'exists:spesialisasi,id'],
            'mulai_praktik' => ['required', 'date_format:H:i'],
            'selesai_praktik' => ['required', 'date_format:H:i'],
        ]);

        Dokter::create($validated);

        return redirect()->route('dokter.index');
    }

    public function show(Dokter $dokter)
    {
        return response()->json(['data' => $dokter]);
    }

    public function edit(Dokter $dokter)
    {
        return response()->json(['data' => $dokter]);
    }

    public function update(Request $request, Dokter $dokter)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'sip' => ['required', 'string', 'max:50', Rule::unique('dokter', 'sip')->ignore($dokter->id)],
            'pengalaman' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'string', 'max:255'],
            'spesialisasi_id' => ['required', 'integer', 'exists:spesialisasi,id'],
            'mulai_praktik' => ['required', 'date_format:H:i'],
            'selesai_praktik' => ['required', 'date_format:H:i'],
        ]);

        $dokter->update($validated);

        return redirect()->route('dokter.index');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();

        return redirect()->route('dokter.index');
    }
}