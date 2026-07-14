@extends('layouts.adminlte4')

@section('content')
    <div class="container-fluid mt-4">

        <h1 class="mb-4">User</h1>

        @if (Auth::user()->role == 'admin')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#btnFormModal">
                + New User
            </button>
        @endif

        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr id="tr_{{ $user->username }}">

                                <td>{{ $user->username }}</td>
                                <td>******</td>
                                <td id="td_role_{{ $user->username }}">
                                    {{ ucfirst($user->role) }}
                                </td>

                                <td>{{ $user->created_at }}</td>

                                <td id="td_updated_{{ $user->username }}">
                                    {{ $user->updated_at }}
                                </td>

                                <td>

                                    <button class="btn btn-warning btn-sm" onclick="getEditForm('{{ $user->username }}')"
                                        data-bs-toggle="modal" data-bs-target="#modalEditUser">

                                        Edit

                                    </button>

                                    <button class="btn btn-danger btn-sm" onclick="prepareDelete('{{ $user->username }}')"
                                        data-bs-toggle="modal" data-bs-target="#modalDeleteUser">

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
    <div class="modal fade" id="btnFormModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New User</h4>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="add-user-errors"></div>

                    <form id="formAddUser">
                        <div class="mb-3">

                            <label>Username</label>

                            <input class="form-control" id="add_username">

                        </div>

                        <div class="mb-3">

                            <label>Password</label>

                            <input type="password" class="form-control" id="add_password">

                        </div>

                        <div class="mb-3">

                            <label>Role</label>

                            <select id="role" class="form-select">

                                <option value="admin">Admin</option>

                                <option value="member">Member</option>

                                <option value="doctor">Doctor</option>

                            </select>
                        </div>
                        

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveNewUser()">Save User</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" id="username" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" id="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" class="form-control">
                    </div>
                    <label class="form-label">Role</label>
                    <select id="edit_role" class="form-select">

                        <option value="admin">Admin</option>

                        <option value="doctor">Doctor</option>

                        <option value="member">Member</option>

                    </select>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveDataUpdate()">
                        Save
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeleteUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Delete User</h4>
                </div>

                <div class="modal-body">
                    <p class="mb-0">
                        Are you sure you want to delete this user?
                    </p>
                    <p class="fw-bold mt-2" id="delete_username_text"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="confirmDeleteUser()">
                        Delete
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>

            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $('#add_member_id').change(function() {

            let selected = $(this).find(':selected');

            $('#add_email').val(selected.data('email'));
            $('#add_phone_number').val(selected.data('phone'));

        });

        function getEditForm(username) {
            $.ajax({
                type: 'POST',
                url: '{{ route('user.getEditForm') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'username': username
                },

                success: function(data) {
                    $('#username').val(data.username);
                    $('#edit_role').val(data.role);
                    $('#member_id').val(data.member_id);
                    $('#doctor_id').val(data.doctor_id);
                    $('#password').val('');
                    $('#password_confirmation').val('');
                },

                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function saveDataUpdate() {
            var username = $('#username').val();
            var password = $('#password').val();
            var password_confirmation = $('#password_confirmation').val();


            $.ajax({
                type: 'POST',
                url: '{{ route('user.saveDataUpdate') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'username': username,
                    'password': password,
                    'password_confirmation': password_confirmation,
                },
                success: function(data) {
                    if (data.status == "oke") {
                        if (data.updated_at) {
                            $('#td_updated_' + username).html(data.updated_at);
                        }

                        // Tutup modal secara otomatis tanpa memunculkan alert box
                        $('#modalEditUser').modal('hide');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = '';
                        $.each(errors, function(key, value) {
                            errorMsg += value + '\n';
                        });
                        alert(errorMsg); // Tetap memunculkan alert hanya jika validasi backend gagal
                    } else {
                        console.log(xhr.responseText);
                    }
                }
            });
        }

        var selectedUsernameToDelete = '';

        // Menyiapkan teks username saat tombol delete di tabel diklik
        function prepareDelete(username) {
            selectedUsernameToDelete = username;
            $('#delete_username_text').text(username);
        }

        // Mengeksekusi AJAX delete setelah tombol delete di dalam modal ditekan
        function confirmDeleteUser() {
            if (!selectedUsernameToDelete) return;

            $.ajax({
                type: 'POST',
                url: '{{ route('user.deleteData') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'username': selectedUsernameToDelete
                },
                success: function(data) {
                    if (data.status == "oke") {
                        // Hapus baris tabel secara real-time dari DOM
                        $('#tr_' + selectedUsernameToDelete).remove();
                        // Tutup modal secara otomatis
                        $('#modalDeleteUser').modal('hide');
                        // Reset penampung
                        selectedUsernameToDelete = '';
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

        $('#role').change(function() {

            $('#add_member_section').hide();

            $('#add_doctor_section').hide();

            if ($(this).val() == "member") {

                $('#add_member_section').show();

            }

            if ($(this).val() == "doctor") {

                $('#add_doctor_section').show();

            }

        });
        $('#role').trigger('change');

        function saveNewUser() {

            $.ajax({

                type: 'POST',

                url: '{{ route('user.storeAjax') }}',

                data: {

                    _token: '{{ csrf_token() }}',

                    username: $('#add_username').val(),

                    password: $('#add_password').val(),

                    role: $('#role').val(),

                    member_id: $('#add_member_id').val(),

                    doctor_id: $('#add_doctor_id').val()

                },

                success: function() {

                    location.reload();

                },

                error: function(xhr) {

                    console.log(xhr.responseText);

                }

            });

        }
    </script>
@endpush
