<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $data = Artikel::query()
            ->orderByDesc('tanggal')
            ->get();

        return view('artikel.index', compact('data'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create artikel belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'isi' => ['required', 'string'],
            'foto' => ['nullable', 'string', 'max:255'],
            'dokter_id' => ['required', 'integer', 'exists:dokter,id'],
        ]);

        Artikel::create($validated);

        return redirect()->route('artikel.index');
    }

    public function show(Artikel $artikel)
    {
        return view('artikel.show', compact('artikel'));
    }

    public function edit(Artikel $artikel)
    {
        return response()->json(['data' => $artikel]);
    }

    public function update(Request $request, Artikel $artikel)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'isi' => ['required', 'string'],
            'foto' => ['nullable', 'string', 'max:255'],
            'dokter_id' => ['required', 'integer', 'exists:dokter,id'],
        ]);

        $artikel->update($validated);

        return redirect()->route('artikel.index');
    }

    public function destroy(Artikel $artikel)
    {
        $artikel->delete();

        return redirect()->route('artikel.index');
    }
}