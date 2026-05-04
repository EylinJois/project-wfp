@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Spesialisasi</h1>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $spesialisasi)
                        <tr>
                            <td class="px-3 py-2">{{ $spesialisasi->id }}</td>
                            <td class="px-3 py-2">{{ $spesialisasi->nama }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
                          