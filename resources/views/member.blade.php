@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Members</h1>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Nama lengkap</th>
                        <th class="px-3 py-2">Tanggal Lahir</th>
                        <th class="px-3 py-2">Foto</th>
                        <th class="px-3 py-2">Dibuat</th>
                        <th class="px-3 py-2">Diperbarui</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $member)
                    <tr>
                        <td class="px-3 py-2">{{ $member->id }}</td>
                        <td class="px-3 py-2">{{ $member->nama_lengkap }}</td>
                        <td class="px-3 py-2">{{ $member->tanggal_lahir }}</td>
                        <td class="px-3 py-2">{{ $member->foto }}</td>
                        <td class="px-3 py-2">{{ $member->created_at }}</td>
                        <td class="px-3 py-2">{{ $member->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection