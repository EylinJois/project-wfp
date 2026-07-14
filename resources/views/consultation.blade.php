@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Consultations</h1>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddConsultation">
        + New Consultation
    </button>

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
                        <th class="px-3 py-2">Actions for Pending Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consultations as $consultation)
                    <tr id="tr_consultation_{{ $consultation->id }}">
                        <td class="px-3 py-2">{{ $consultation->id }}</td>
                        <td class="px-3 py-2" id="td_member_{{ $consultation->id }}">{{ $consultation->member_id }}</td>
                        <td class="px-3 py-2" id="td_doctor_{{ $consultation->id }}">{{ $consultation->doctor_id }}</td>
                        <td class="px-3 py-2" id="td_time_{{ $consultation->id }}">{{ $consultation->time }}</td>
                        <td class="px-3 py-2" id="td_status_{{ $consultation->id }}">{{ $consultation->status }}</td>
                        <td class="px-3 py-2" id="td_type_{{ $consultation->id }}">{{ $consultation->consultation_type }}</td>
                        <td class="px-3 py-2" id="td_notes_{{ $consultation->id }}">{{ $consultation->notes }}</td>
                        <td class="px-3 py-2">{{ $consultation->created_at }}</td>
                        <td class="px-3 py-2" id="td_updated_{{ $consultation->id }}">{{ $consultation->updated_at }}</td>
                        <td class="px-3 py-2">
                            @if($consultation->status === 'pending')
                            <button
                                type="button"
                                class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditConsultation"
                                onclick="getEditForm({{ $consultation->id }})">
                                Update
                            </button>

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDeleteConsultation"
                                onclick="prepareDelete({{ $consultation->id }})">
                                Delete
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
@endsection

@push('modals')
<div class="modal fade" id="modalAddConsultation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Consultation</h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger d-none" id="add-consultation-errors"></div>

                <form id="formAddConsultation">
                    <div class="mb-3">
                        <label class="form-label">Member</label>
                        <select name="member_id" id="add_member_id" class="form-control" required>
                            <option value="">-- Select Member --</option>
                            @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Doctor</label>
                        <select name="doctor_id" id="add_doctor_id" class="form-control" required>
                            <option value="">-- Select Doctor --</option>
                            @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->fullname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Time</label>
                        <input type="datetime-local" name="time" id="add_time" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="add_status" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Consultation Type</label>
                        <select name="consultation_type" id="add_consultation_type" class="form-control" required>
                            <option value="general consultation">General Consultation</option>
                            <option value="specialist consultation">Specialist Consultation</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="add_notes" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveNewConsultation()">Save Consultation</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditConsultation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Consultation</h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger d-none" id="edit-consultation-errors"></div>

                <form id="formEditConsultation">
                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label">Member</label>
                        <select id="edit_member_id" class="form-control" required>
                            <option value="">-- Select Member --</option>
                            @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->fullname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Doctor</label>
                        <select id="edit_doctor_id" class="form-control" required>
                            <option value="">-- Select Doctor --</option>
                            @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->fullname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Time</label>
                        <input type="datetime-local" id="edit_time" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select id="edit_status" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="done">Done</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Consultation Type</label>
                        <select id="edit_consultation_type" class="form-control" required>
                            <option value="general consultation">General Consultation</option>
                            <option value="specialist consultation">Specialist Consultation</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea id="edit_notes" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveDataUpdate()">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteConsultation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Consultation</h4>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this consultation?</p>
                <p class="fw-bold mt-2" id="delete_consultation_text"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="confirmDeleteConsultation()">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function saveNewConsultation() {
        $('#add-consultation-errors').addClass('d-none').html('');

        $.ajax({
            type: 'POST',
            url: '{{ route("consultation.storeAjax") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'member_id': $('#add_member_id').val(),
                'doctor_id': $('#add_doctor_id').val(),
                'time': $('#add_time').val(),
                'status': $('#add_status').val(),
                'consultation_type': $('#add_consultation_type').val(),
                'notes': $('#add_notes').val()
            },
            success: function(data) {
                if (data.status == "oke") {
                    var c = data.consultation;
                    var newRow = `
                    <tr id="tr_consultation_${c.id}">
                        <td class="px-3 py-2">${c.id}</td>
                        <td class="px-3 py-2" id="td_member_${c.id}">${c.member_id}</td>
                        <td class="px-3 py-2" id="td_doctor_${c.id}">${c.doctor_id}</td>
                        <td class="px-3 py-2" id="td_time_${c.id}">${c.time}</td>
                        <td class="px-3 py-2" id="td_status_${c.id}">${c.status}</td>
                        <td class="px-3 py-2" id="td_type_${c.id}">${c.consultation_type}</td>
                        <td class="px-3 py-2" id="td_notes_${c.id}">${c.notes ?? ''}</td>
                        <td class="px-3 py-2">${c.created_at}</td>
                        <td class="px-3 py-2" id="td_updated_${c.id}">${c.updated_at}</td>
                        <td class="px-3 py-2">
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditConsultation" onclick="getEditForm(${c.id})">Update</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteConsultation" onclick="prepareDelete(${c.id})">Delete</button>
                        </td>
                    </tr>
                `;

                    $('table tbody').prepend(newRow);

                    $('#modalAddConsultation').modal('hide');
                    $('#formAddConsultation')[0].reset();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorList = '<ul>';
                    $.each(errors, function(key, value) {
                        errorList += '<li>' + value + '</li>';
                    });
                    errorList += '</ul>';
                    $('#add-consultation-errors').removeClass('d-none').html(errorList);
                } else {
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan sistem saat menambah consultation.');
                }
            }
        });
    }

    function getEditForm(id) {
        $('#edit-consultation-errors').addClass('d-none').html('');

        $.ajax({
            type: 'POST',
            url: '{{ route("consultation.getEditForm") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': id
            },
            success: function(data) {
                $('#edit_id').val(data.id);
                $('#edit_member_id').val(data.member_id);
                $('#edit_doctor_id').val(data.doctor_id);
                $('#edit_time').val(data.time);
                $('#edit_status').val(data.status);
                $('#edit_consultation_type').val(data.consultation_type);
                $('#edit_notes').val(data.notes);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function saveDataUpdate() {
        $('#edit-consultation-errors').addClass('d-none').html('');

        var id = $('#edit_id').val();

        $.ajax({
            type: 'POST',
            url: '{{ route("consultation.saveDataUpdate") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': id,
                'member_id': $('#edit_member_id').val(),
                'doctor_id': $('#edit_doctor_id').val(),
                'time': $('#edit_time').val(),
                'status': $('#edit_status').val(),
                'consultation_type': $('#edit_consultation_type').val(),
                'notes': $('#edit_notes').val()
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#td_member_' + id).html(data.member_id);
                    $('#td_doctor_' + id).html(data.doctor_id);
                    $('#td_time_' + id).html(data.time);
                    $('#td_status_' + id).html(data.consultation_status);
                    $('#td_type_' + id).html(data.consultation_type);
                    $('#td_notes_' + id).html(data.notes ?? '');
                    $('#td_updated_' + id).html(data.updated_at);

                    $('#modalEditConsultation').modal('hide');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorList = '<ul>';
                    $.each(errors, function(key, value) {
                        errorList += '<li>' + value + '</li>';
                    });
                    errorList += '</ul>';
                    $('#edit-consultation-errors').removeClass('d-none').html(errorList);
                } else {
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan sistem saat mengupdate consultation.');
                }
            }
        });
    }

    var selectedConsultationIdToDelete = '';

    function prepareDelete(id) {
        selectedConsultationIdToDelete = id;
        $('#delete_consultation_text').text('Consultation #' + id);
    }

    function confirmDeleteConsultation() {
        if (!selectedConsultationIdToDelete) return;

        $.ajax({
            type: 'POST',
            url: '{{ route("consultation.deleteData") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': selectedConsultationIdToDelete
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#tr_consultation_' + selectedConsultationIdToDelete).remove();
                    $('#modalDeleteConsultation').modal('hide');
                    selectedConsultationIdToDelete = '';
                } else {
                    alert(data.msg || 'Gagal menghapus data.');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan sistem saat menghapus.');
            }
        });
    }
</script>
@endpush