@extends('layout.app')

@section('content')
<h1>User</h1>
<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
            <th>Nomor Telepon</th>
            <th>Is Admin</th>
            <th>ID Member</th>
            <th>ID Dokter</th>
            <th>Dibuat</th>
            <th>Diperbarui</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->password }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->nomor_telepon }}</td>
                <td>{{ $user->is_admin }}</td>
                <td>{{ $user->member_id }}</td>
                <td>{{ $user->dokter_id }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>