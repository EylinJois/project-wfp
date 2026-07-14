@extends('layouts.adminlte4')

@section('content')
    <div class="container-fluid mt-4">

        <h1 class="mb-4">Members</h1>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddMember">
            + New Member
        </button>

        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-2">ID</th>
                            <th class="px-3 py-2">Full name</th>
                            <th class="px-3 py-2">Email</th>
                            <th class="px-3 py-2">Phone</th>
                            <th class="px-3 py-2">Date of Birth</th>
                            <th class="px-3 py-2">Photo</th>
                            <th class="px-3 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr id="tr_member_{{ $member->id }}">
                                <td class="px-3 py-2">{{ $member->id }}</td>
                                <td class="px-3 py-2" id="td_fullname_{{ $member->id }}">{{ $member->fullname }}</td>
                                <td class="px-3 py-2" id="td_email_{{ $member->id }}">{{ $member->email }}</td>
                                <td class="px-3 py-2" id="td_phone_{{ $member->id }}">{{ $member->phone }}</td>
                                <td class="px-3 py-2" id="td_birth_{{ $member->id }}">{{ $member->birth_of_date }}</td>
                                <td class="px-3 py-2" id="td_photo_{{ $member->id }}">
                                    @if ($member->photo)
                                        <img src="{{ Storage::url($member->photo) }}" alt="photo" width="60">
                                    @endif
                                </td>
                                <td class="px-3 py-2">{{ $member->created_at }}</td>
                                <td class="px-3 py-2" id="td_updated_{{ $member->id }}">{{ $member->updated_at }}</td>
                                <td class="px-3 py-2">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEditMember" onclick="getEditForm({{ $member->id }})">
                                        Update
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalDeleteMember"
                                        onclick="prepareDelete({{ $member->id }}, '{{ $member->fullname }}')">
                                        Delete
                                    </button>
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
    <div class="modal fade" id="modalAddMember" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Member</h4>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="add-member-errors"></div>

                    <form id="formAddMember" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="fullname" id="add_fullname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="add_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" id="add_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="birth_of_date" id="add_birth_of_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" id="add_photo" class="form-control" accept="image/*"
                                required>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveNewMember()">Save Member</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditMember" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Member</h4>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="edit-member-errors"></div>

                    <form id="formEditMember" enctype="multipart/form-data">
                        <input type="hidden" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" id="edit_fullname" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="edit_email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" id="edit_phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" id="edit_birth_of_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Photo</label><br>
                            <img id="edit_current_photo" src="" alt="" width="80"
                                class="mb-2 d-none">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Replace Photo (optional)</label>
                            <input type="file" id="edit_photo" class="form-control" accept="image/*">
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

    <div class="modal fade" id="modalDeleteMember" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Member</h4>
                </div>

                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete this member?</p>
                    <p class="fw-bold mt-2" id="delete_member_text"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="confirmDeleteMember()">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        function saveNewMember() {
            $('#add-member-errors').addClass('d-none').html('');

            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('fullname', $('#add_fullname').val());
            formData.append('email', $('#add_email').val());
            formData.append('phone', $('#add_phone').val());
            formData.append('birth_of_date', $('#add_birth_of_date').val());
            formData.append('photo', $('#add_photo')[0].files[0]);

            $.ajax({
                type: 'POST',
                url: '{{ route('member.storeAjax') }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == "oke") {
                        var m = data.member;
                        var newRow = `
                    <tr id="tr_member_${m.id}">
                        <td class="px-3 py-2">${m.id}</td>
                        <td class="px-3 py-2" id="td_fullname_${m.id}">${m.fullname}</td>
                        <td class="px-3 py-2" id="td_email_${m.id}">${m.email}</td>
                        <td class="px-3 py-2" id="td_phone_${m.id}">${m.phone}</td>
                        <td class="px-3 py-2" id="td_birth_${m.id}">${m.birth_of_date}</td>
                        <td class="px-3 py-2" id="td_photo_${m.id}"><img src="${m.photo_url}" alt="photo" width="60"></td>
                     
                        <td class="px-3 py-2">
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditMember" onclick="getEditForm(${m.id})">Update</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteMember" onclick="prepareDelete(${m.id}, '${m.fullname}')">Delete</button>
                        </td>
                    </tr>
                `;

                        $('table tbody').prepend(newRow);

                        $('#modalAddMember').modal('hide');
                        $('#formAddMember')[0].reset();
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
                        $('#add-member-errors').removeClass('d-none').html(errorList);
                    } else {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan sistem saat menambah member.');
                    }
                }
            });
        }

        function getEditForm(id) {
            $('#edit-member-errors').addClass('d-none').html('');

            $.ajax({
                type: 'POST',
                url: '{{ route('member.getEditForm') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id
                },
                success: function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_fullname').val(data.fullname);
                    $('#edit_email').val(data.email);
                    $('#edit_phone').val(data.phone);
                    $('#edit_birth_of_date').val(data.birth_of_date);
                    $('#edit_photo').val('');

                    if (data.photo_url) {
                        $('#edit_current_photo').attr('src', data.photo_url).removeClass('d-none');
                    } else {
                        $('#edit_current_photo').addClass('d-none');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function saveDataUpdate() {
            $('#edit-member-errors').addClass('d-none').html('');

            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id', $('#edit_id').val());
            formData.append('fullname', $('#edit_fullname').val());
            formData.append('email', $('#edit_email').val());
            formData.append('phone', $('#edit_phone').val());
            formData.append('birth_of_date', $('#edit_birth_of_date').val());

            var photoFile = $('#edit_photo')[0].files[0];
            if (photoFile) {
                formData.append('photo', photoFile);
            }

            var id = $('#edit_id').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('member.saveDataUpdate') }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == "oke") {
                        $('#td_fullname_' + id).html(data.fullname);
                        $('#td_email_' + id).html(data.email);
                        $('#td_phone_' + id).html(data.phone);
                        $('#td_birth_' + id).html(data.birth_of_date);
                        $('#td_photo_' + id).html('<img src="' + data.photo_url + '" alt="photo" width="60">');
                        $('#td_updated_' + id).html(data.updated_at);

                        $('#modalEditMember').modal('hide');
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
                        $('#edit-member-errors').removeClass('d-none').html(errorList);
                    } else {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan sistem saat mengupdate member.');
                    }
                }
            });
        }

        var selectedMemberIdToDelete = '';

        function prepareDelete(id, fullname) {
            selectedMemberIdToDelete = id;
            $('#delete_member_text').text(fullname);
        }

        function confirmDeleteMember() {
            if (!selectedMemberIdToDelete) return;

            $.ajax({
                type: 'POST',
                url: '{{ route('member.deleteData') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': selectedMemberIdToDelete
                },
                success: function(data) {
                    if (data.status == "oke") {
                        $('#tr_member_' + selectedMemberIdToDelete).remove();
                        $('#modalDeleteMember').modal('hide');
                        selectedMemberIdToDelete = '';
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
