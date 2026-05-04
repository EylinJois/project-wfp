@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Dokter</h1>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Nama lengkap</th>
                        <th class="px-3 py-2">SIP</th>
                        <th class="px-3 py-2">Pengalaman</th>
                        <th class="px-3 py-2">Foto</th>
                        <th class="px-3 py-2">ID Spesialisasi</th>
                        <th class="px-3 py-2">Mulai Praktik</th>
                        <th class="px-3 py-2">Selesai Praktik</th>
                        <th class="px-3 py-2">Dibuat</th>
                        <th class="px-3 py-2">Diperbarui</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dokter)
                        <tr>
                            <td class="px-3 py-2">{{ $dokter->id }}</td>
                            <td class="px-3 py-2">{{ $dokter->nama_lengkap }}</td>
                            <td class="px-3 py-2">{{ $dokter->sip }}</td>
                            <td class="px-3 py-2">{{ $dokter->pengalaman }}</td>
                            <td class="px-3 py-2">{{ $dokter->foto }}</td>
                            <td class="px-3 py-2">{{ $dokter->spesialisasi_id }}</td>
                            <td class="px-3 py-2">{{ $dokter->mulai_praktik }}</td>
                            <td class="px-3 py-2">{{ $dokter->selesai_praktik }}</td>
                            <td class="px-3 py-2">{{ $dokter->created_at }}</td>
                            <td class="px-3 py-2">{{ $dokter->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection