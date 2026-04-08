@extends('layout.app')

@section('content')
<h1>Konsultasi</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Member</th>
            <th>ID Dokter</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Jenis Konsultasi</th>
            <th>Catatan</th>
            <th>Dibuat</th>
            <th>Diperbarui</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $konsultasi)
            <tr>
                <td>{{ $konsultasi->id }}</td>
                <td>{{ $konsultasi->member_id }}</td>
                <td>{{ $konsultasi->dokter_id }}</td>
                <td>{{ $konsultasi->waktu }}</td>
                <td>{{ $konsultasi->status }}</td>
                <td>{{ $konsultasi->jenis_konsultasi }}</td>
                <td>{{ $konsultasi->catatan }}</td>
                <td>{{ $konsultasi->created_at }}</td>
                <td>{{ $konsultasi->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>