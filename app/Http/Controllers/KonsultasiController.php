<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KonsultasiController extends Controller
{
    public function index()
    {
        $data = Konsultasi::query()
            ->orderByDesc('waktu')
            ->get();

        return view('konsultasi', compact('data'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create konsultasi belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waktu' => ['required', 'date'],
            'status' => ['required', 'string', 'max:20'],
            'jenis_konsultasi' => ['required', Rule::in(['kosong', 'sedang berlangsung', 'selesai'])],
            'catatan' => ['nullable', 'string'],
            'member_id' => ['required', 'integer', 'exists:member,id'],
            'dokter_id' => ['required', 'integer', 'exists:dokter,id'],
        ]);

        Konsultasi::create($validated);

        return redirect()->route('konsultasi.index');
    }

    public function show(Konsultasi $konsultasi)
    {
        return response()->json(['data' => $konsultasi]);
    }

    public function edit(Konsultasi $konsultasi)
    {
        return response()->json(['data' => $konsultasi]);
    }

    public function update(Request $request, Konsultasi $konsultasi)
    {
        $validated = $request->validate([
            'waktu' => ['required', 'date'],
            'status' => ['required', 'string', 'max:20'],
            'jenis_konsultasi' => ['required', Rule::in(['kosong', 'sedang berlangsung', 'selesai'])],
            'catatan' => ['nullable', 'string'],
            'member_id' => ['required', 'integer', 'exists:member,id'],
            'dokter_id' => ['required', 'integer', 'exists:dokter,id'],
        ]);

        $konsultasi->update($validated);

        return redirect()->route('konsultasi.index');
    }

    public function destroy(Konsultasi $konsultasi)
    {
        $konsultasi->delete();

        return redirect()->route('konsultasi.index');
    }
}