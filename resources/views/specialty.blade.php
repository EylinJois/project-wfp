@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Specialty</h1>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($specialties as $specialty)
                        <tr>
                            <td class="px-3 py-2">{{ $specialty->id }}</td>
                            <td class="px-3 py-2">{{ $specialty->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
                          