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
                        <th class="px-3 py-2">Chat</th>
                        <th class="px-3 py-2">ID Doctor</th>
                        <th class="px-3 py-2">ID Member</th>
                        <th class="px-3 py-2">ID Consultation</th>
                        <th class="px-3 py-2">Delivered at</th>
                        <th class="px-3 py-2">Created</th>
                        <th class="px-3 py-2">Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chats as $chat)
                    <tr>
                        <td class="px-3 py-2">{{ $chat->id }}</td>
                        <td class="px-3 py-2">{{ $chat->chat }}</td>
                        <td class="px-3 py-2">{{ $chat->doctor_id }}</td>
                        <td class="px-3 py-2">{{ $chat->member_id }}</td>
                        <td class="px-3 py-2">{{ $chat->consultation_id }}</td>
                        <td class="px-3 py-2">{{ $chat->delivered_at }}</td>
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