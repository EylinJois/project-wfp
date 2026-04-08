@extends('layout.app')

@section('content')
<h1>Member</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama lengkap</th>
            <th>Tanggal Lahir</th>
            <th>Foto</th>
            <th>Dibuat</th>
            <th>Diperbarui</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $member)
            <tr>
                <td>{{ $member->id }}</td>
                <td>{{ $member->nama_lengkap }}</td>
                <td>{{ $member->tanggal_lahir }}</td>
                <td>{{ $member->foto }}</td>
                <td>{{ $member->created_at }}</td>
                <td>{{ $member->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>