@extends('layout.app')

@section('content')
<h1>Artikel</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Isi</th>
            <th>Foto</th>
            <th>ID Dokter</th>
            <th>Dibuat</th>
            <th>Diperbarui</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->judul }}</td>
                <td>{{ $article->tanggal }}</td>
                <td>{{ $article->isi }}</td>
                <td>{{ $article->foto }}</td>
                <td>{{ $article->dokter_id }}</td>
                <td>{{ $article->created_at }}</td>
                <td>{{ $article->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>