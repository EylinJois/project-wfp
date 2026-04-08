@extends('layout.app')

@section('content')
<h1>Spesialisasi</h1>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $member)
            <tr>
                <td>{{ $member->id }}</td>
                <td>{{ $member->nama }}</td>
            </tr>
        @endforeach
    </tbody>
</table>