@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Chats</h1>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Pesan</th>
                        <th class="px-3 py-2">ID Dokter</th>
                        <th class="px-3 py-2">ID Member</th>
                        <th class="px-3 py-2">ID Konsultasi</th>
                        <th class="px-3 py-2">Waktu Kirim</th>
                        <th class="px-3 py-2">Dibuat</th>
                        <th class="px-3 py-2">Diperbarui</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $chat)
                    <tr>
                        <td class="px-3 py-2">{{ $chat->id }}</td>
                        <td class="px-3 py-2">{{ $chat->pesan }}</td>
                        <td class="px-3 py-2">{{ $chat->dokter_id }}</td>
                        <td class="px-3 py-2">{{ $chat->member_id }}</td>
                        <td class="px-3 py-2">{{ $chat->konsultasi_id }}</td>
                        <td class="px-3 py-2">{{ $chat->waktu_kirim }}</td>
                        <td class="px-3 py-2">{{ $chat->created_at }}</td>
                        <td class="px-3 py-2">{{ $chat->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection