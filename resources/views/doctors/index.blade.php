@extends('layouts.adminlte4')

@section('menu-doctors', 'active')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Dokter</h1>

    @if (@session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#btnFormModal">
        + New Doctor
    </button>

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
                        <th class="px-3 py-2">Specialization ID - Name</th>
                        <th class="px-3 py-2">Start Practice</th>
                        <th class="px-3 py-2">Selesai Praktik</th>
                        <th class="px-3 py-2">Created At</th>
                        <th class="px-3 py-2">Updated At</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                    <tr>
                        <td class="px-3 py-2">{{ $doctor->id }}</td>
                        <td class="px-3 py-2">{{ $doctor->fullname }}</td>
                        <td class="px-3 py-2">{{ $doctor->sip }}</td>
                        <td class="px-3 py-2">{{ $doctor->experience }}</td>
                        <td class="px-3 py-2">{{ $doctor->photo }}</td>
                        <td class="px-3 py-2">{{ $doctor->specialty->id }} - {{ $doctor->specialty->name ?? 'N/A' }}</td>
                        <td class="px-3 py-2">{{ $doctor->start_time }}</td>
                        <td class="px-3 py-2">{{ $doctor->end_time }}</td>
                        <td class="px-3 py-2">{{ $doctor->created_at }}</td>
                        <td class="px-3 py-2">{{ $doctor->updated_at }}</td>
                        <td class="px-3 py-2">
                            <a href="{{ route('doctor.edit', $doctor->id) }}" class="btn btn-sm btn-warning mb-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('doctor.destroy', $doctor->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mb-1"
                                    onclick="return confirm('Are you sure you want to delete this doctor?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('modals')
<div class="modal fade" id="btnFormModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Doctor</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('doctor.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="sip" class="form-label">SIP</label>
                        <input type="text" class="form-control" id="sip" name="sip" required>
                    </div>
                    <div class="mb-3">
                        <label for="experience" class="form-label">Experience</label>
                        <input type="text" class="form-control" id="experience" name="experience" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" accept="image/*" class="form-control" id="photo" name="photo">
                    </div>
                    <div class="mb-3">
                        <label for="specialty_id" class="form-label">Specialty</label>
                        <select class="form-control" id="specialty_id" name="specialty_id" required>
                            <option value="">Select Specialty</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endpush

@endsection