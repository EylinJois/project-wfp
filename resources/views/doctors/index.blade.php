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

    @if (@Auth::user()->is_admin)
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#btnFormModal">
        + New Doctor
    </button>
    @endif

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        @if (@Auth::user()->is_admin)
                        <th class="px-3 py-2">ID</th>
                        @endif
                        <th class="px-3 py-2">Full Name</th>
                        @if (@Auth::user()->is_admin)
                        <th class="px-3 py-2">SIP</th>
                        <th class="px-3 py-2">Experience</th>
                        <th class="px-3 py-2">Photo</th>
                        @endif
                        <th class="px-3 py-2">Specialization</th>
                        <th class="px-3 py-2">Start Practice</th>
                        <th class="px-3 py-2">Selesai Praktik</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                    <tr id="tr_{{ $doctor->id }}">
                        @if (@Auth::user()->is_admin)
                        <td class="px-3 py-2">{{ $doctor->id }}</td>
                        @endif
                        <td class="px-3 py-2" id="td_name_{{ $doctor->id }}">{{ $doctor->fullname }}</td>
                        @if (@Auth::user()->is_admin)
                        <td class="px-3 py-2" id="td_sip_{{ $doctor->id }}">{{ $doctor->sip }}</td>
                        <td class="px-3 py-2" id="td_experience_{{ $doctor->id }}">{{ $doctor->experience }}</td>
                        <td class="px-3 py-2" id="td_photo_{{ $doctor->id }}">
                            <!-- {{ $doctor->photo }} -->
                            <img src="{{ asset('storage/photos/' . $doctor->photo) }}" width="100">
                        </td>
                        @endif
                        <td class="px-3 py-2" id="td_specialty_id_{{ $doctor->id }}">{{ $doctor->specialty->name ?? 'N/A' }}</td>
                        <td class="px-3 py-2" id="td_start_time_{{ $doctor->id }}">{{ $doctor->start_time }}</td>
                        <td class="px-3 py-2" id="td_end_time_{{ $doctor->id }}">{{ $doctor->end_time }}</td>
                        <td class="px-3 py-2">
                            <a href="{{ route('doctor.show', $doctor->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if (@Auth::user()->is_admin)
                            <a href="#modalEditB"
                                class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                onclick="getEditFormB({{ $doctor->id }})">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                onclick="if(confirm('Are you sure to delete {{ $doctor->id }} - {{ $doctor->fullname }} ?')) 
                                deleteDataRemove({{ $doctor->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                            @endif
                        </td>
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

<div class="modal fade" id="modalEditB" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Doctor's Data</h4>
            </div>
            <div class="modal-body" id="modalContentB">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push("scripts")
<script>
    function getEditFormB(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.getEditFormB") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id
            },
            success: function(data) {
                $('#modalContentB').html(data.msg)
            }
        });
    }

    function saveDataUpdate(id) {
        var fullname = $('#fullname').val();
        var sip = $('#sip').val();
        var experience = $('#experience').val();
        var photo = $('#photo')[0].files[0];
        var specialty_id = $('#specialty_id').val();
        var start_time = $('#start_time').val();
        var end_time = $('#end_time').val();

        let formData = new FormData();

        formData.append('_token', '{{ csrf_token() }}');
        formData.append('id', id);
        formData.append('fullname', fullname);
        formData.append('sip', sip);
        formData.append('experience', experience);
        formData.append('specialty_id', specialty_id);
        formData.append('start_time', start_time);
        formData.append('end_time', end_time);

        // append photo only if selected
        if (photo) {
            formData.append('photo', photo);
        }

        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.saveDataUpdate") }}',
            data: formData,

            processData: false, // important
            contentType: false, // important

            success: function(data) {
                if (data.status == "oke") {

                    $('#td_name_' + id).html(fullname);
                    $('#td_sip_' + id).html(sip);
                    $('#td_experience_' + id).html(experience);
                    $('#td_specialty_id_' + id).html(data.specialty_name);
                    $('#td_photo_' + id).html(
                        '<img src="' + data.photo_url + '" width="100">'
                    );
                    $('#td_start_time_' + id).html(start_time);
                    $('#td_end_time_' + id).html(end_time);

                    $('#modalEditB').modal('hide');
                }
            },

            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.deleteData") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#tr_' + id).remove();
                }
            }
        });
    }
</script>
@endpush
@endsection