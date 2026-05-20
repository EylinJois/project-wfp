@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Dokter</h1>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Full Name</th>
                        <th class="px-3 py-2">SIP</th>
                        <th class="px-3 py-2">Experience</th>
                        <th class="px-3 py-2">Photo</th>
                        <th class="px-3 py-2">Specialization ID</th>
                        <th class="px-3 py-2">Start Practice</th>
                        <th class="px-3 py-2">Selesai Praktik</th>
                        <th class="px-3 py-2">Created At</th>
                        <th class="px-3 py-2">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr>
                            <td class="px-3 py-2">{{ $doctor->id }}</td>
                            <td class="px-3 py-2">{{ $doctor->full_name }}</td>
                            <td class="px-3 py-2">{{ $doctor->sip }}</td>
                            <td class="px-3 py-2">{{ $doctor->experience }}</td>
                            <td class="px-3 py-2">{{ $doctor->photo }}</td>
                            <td class="px-3 py-2">{{ $doctor->specialization_id }}</td>
                            <td class="px-3 py-2">{{ $doctor->start_practice }}</td>
                            <td class="px-3 py-2">{{ $doctor->end_practice }}</td>
                            <td class="px-3 py-2">{{ $doctor->created_at }}</td>
                            <td class="px-3 py-2">{{ $doctor->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection