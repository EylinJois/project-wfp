@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Articles</h1>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Judul</th>
                        <th class="px-3 py-2">Tanggal</th>
                        <th class="px-3 py-2">Isi</th>
                        <th class="px-3 py-2">Foto</th>
                        <th class="px-3 py-2">ID Dokter</th>
                        <th class="px-3 py-2">Dibuat</th>
                        <th class="px-3 py-2">Diperbarui</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $article)
                    <tr>
                        <td class="px-3 py-2">{{ $article->id }}</td>
                        <td class="px-3 py-2">{{ $article->judul }}</td>
                        <td class="px-3 py-2">{{ $article->tanggal }}</td>
                        <td class="px-3 py-2">{{ $article->isi }}</td>
                        <td class="px-3 py-2">{{ $article->foto }}</td>
                        <td class="px-3 py-2">{{ $article->dokter_id }}</td>
                        <td class="px-3 py-2">{{ $article->created_at }}</td>
                        <td class="px-3 py-2">{{ $article->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection