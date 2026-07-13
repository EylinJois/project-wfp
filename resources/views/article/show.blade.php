@extends('layouts.adminlte4')

@section('title', 'Detail Artikel')

@section('content')
<div class="container">
    <h1>{{ $article->title }}</h1>
    <div class="mb-3">
        @if ($article->photo)
        <img src="{{ asset('storage/photos/' . $article->photo) }}"
            alt="Foto Artikel"
            class="img-fluid rounded"
            style="max-height: 300px; object-fit: cover;">
        @else
        <p>No photo available.</p>
        @endif
    </div>
    <p><b>Tanggal:</b> {{ $article->date }}</p>
    <p><b>Isi:</b></p>
    <p>{{ $article->content }}</p>

    <p><b>Dokter:</b> {{ $article->doctor->fullname ?? 'N/A' }}</p>
</div>
@endsection