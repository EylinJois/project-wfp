@extends('layout.app')

@section('content')
<h1>Chat</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Pesan</th>
            <th>ID Dokter</th>
            <th>ID Member</th>
            <th>ID Konsultasi</th>
            <th>Waktu Kirim</th>
            <th>Dibuat</th>
            <th>Diperbarui</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $chat)
            <tr>
                <td>{{ $chat->id }}</td>
                <td>{{ $chat->pesan }}</td>
                <td>{{ $chat->dokter_id }}</td>
                <td>{{ $chat->member_id }}</td>
                <td>{{ $chat->konsultasi_id }}</td>
                <td>{{ $chat->waktu_kirim }}</td>
                <td>{{ $chat->created_at }}</td>
                <td>{{ $chat->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>