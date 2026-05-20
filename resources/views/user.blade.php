@extends('layouts.adminlte4')

@section('content')
    <div class="container-fluid mt-4">

        <h1 class="mb-4">User</h1>

        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-2">Username</th>
                            <th class="px-3 py-2">Password</th>
                            <th class="px-3 py-2">Email</th>
                            <th class="px-3 py-2">Phone Number</th>
                            <th class="px-3 py-2">Is Admin</th>
                            <th class="px-3 py-2">ID Member</th>
                            <th class="px-3 py-2">ID Doctor</th>
                            <th class="px-3 py-2">Created At</th>
                            <th class="px-3 py-2">Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-3 py-2">{{ $user->username }}</td>
                                <td class="px-3 py-2">{{ $user->password }}</td>
                                <td class="px-3 py-2">{{ $user->email }}</td>
                                <td class="px-3 py-2">{{ $user->phone_number }}</td>
                                <td class="px-3 py-2">{{ $user->is_admin }}</td>
                                <td class="px-3 py-2">{{ $user->member_id }}</td>
                                <td class="px-3 py-2">{{ $user->doctor_id }}</td>
                                <td class="px-3 py-2">{{ $user->created_at }}</td>
                                <td class="px-3 py-2">{{ $user->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
