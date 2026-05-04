@extends('layouts.adminlte4')

@section('title', 'List of Articles')

@section('content')
<div class="container">
    <h1>List of Articles</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->judul }}</td>
                <td>{{ $article->tanggal }}</td>
                <td>
                    <a href="{{ route('artikel.show', $article->id) }}"
                        class="btn btn-primary btn-sm">
                        Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection