@extends('layouts.adminlte4')

@section('title', 'Detail Artikel')

@section('content')
<div class="container">
    <h1>{{ $artikel->judul }}</h1>
    <div class="mb-3">
        @if ($artikel->foto)
        <img src="{{ asset('storage/' . $artikel->foto) }}"
            alt="Foto Artikel"
            class="img-fluid rounded"
            style="max-height: 300px; object-fit: cover;">
        @else
        <p>No photo available.</p>
        @endif
    </div>
    <p><b>Tanggal:</b> {{ $artikel->tanggal }}</p>
    <p><b>Isi:</b></p>
    <p>{{ $artikel->isi }}</p>

    <p><b>Dokter:</b> {{ $artikel->dokter->nama_lengkap ?? 'N/A' }}</p>
    <a href="{{ route('artikel.index') }}" class="btn btn-secondary">
        Back
    </a>
</div>
@endsection