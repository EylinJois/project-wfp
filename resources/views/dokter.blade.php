@extends('layout.app')

@section('content')
<h1>Dokter</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama lengkap</th>
            <th>SIP</th>
            <th>Pengalaman</th>
            <th>Foto</th>
            <th>ID Spesialisasi</th>
            <th>Mulai Praktik</th>
            <th>Selesai Praktik</th>
            <th>Dibuat</th>
            <th>Diperbarui</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dokter)
            <tr>
                <td>{{ $dokter->id }}</td>
                <td>{{ $dokter->nama_lengkap }}</td>
                <td>{{ $dokter->sip }}</td>
                <td>{{ $dokter->pengalaman }}</td>
                <td>{{ $dokter->foto }}</td>
                <td>{{ $dokter->spesialisasi_id }}</td>
                <td>{{ $dokter->mulai_praktik }}</td>
                <td>{{ $dokter->selesai_praktik }}</td>
                <td>{{ $dokter->created_at }}</td>
                <td>{{ $dokter->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>