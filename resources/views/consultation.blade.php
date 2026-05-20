@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Consultations</h1>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">ID Member</th>
                        <th class="px-3 py-2">ID Doctor</th>
                        <th class="px-3 py-2">Time</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Consultation Type</th>
                        <th class="px-3 py-2">Notes</th>
                        <th class="px-3 py-2">Created</th>
                        <th class="px-3 py-2">Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consultations as $consultation)
                    <tr>
                        <td class="px-3 py-2">{{ $consultation->id }}</td>
                        <td class="px-3 py-2">{{ $consultation->member_id }}</td>
                        <td class="px-3 py-2">{{ $consultation->doctor_id }}</td>
                        <td class="px-3 py-2">{{ $consultation->time }}</td>
                        <td class="px-3 py-2">{{ $consultation->status }}</td>
                        <td class="px-3 py-2">{{ $consultation->consultation_type }}</td>
                        <td class="px-3 py-2">{{ $consultation->notes }}</td>
                        <td class="px-3 py-2">{{ $consultation->created_at }}</td>
                        <td class="px-3 py-2">{{ $consultation->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
