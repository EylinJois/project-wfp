@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Consultations</h1>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">ID Member</th>
                        <th class="px-3 py-2">ID Dokter</th>
                        <th class="px-3 py-2">Waktu</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Jenis Konsultasi</th>
                        <th class="px-3 py-2">Catatan</th>
                        <th class="px-3 py-2">Dibuat</th>
                        <th class="px-3 py-2">Diperbarui</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $konsultasi)
                    <tr>
                        <td class="px-3 py-2">{{ $konsultasi->id }}</td>
                        <td class="px-3 py-2">{{ $konsultasi->member_id }}</td>
                        <td class="px-3 py-2">{{ $konsultasi->dokter_id }}</td>
                        <td class="px-3 py-2">{{ $konsultasi->waktu }}</td>
                        <td class="px-3 py-2">{{ $konsultasi->status }}</td>
                        <td class="px-3 py-2">{{ $konsultasi->jenis_konsultasi }}</td>
                        <td class="px-3 py-2">{{ $konsultasi->catatan }}</td>
                        <td class="px-3 py-2">{{ $konsultasi->created_at }}</td>
                        <td class="px-3 py-2">{{ $konsultasi->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
