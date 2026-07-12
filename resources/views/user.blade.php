@extends('layouts.adminlte4')

@section('content')
    <div class="container-fluid mt-4">

        <h1 class="mb-4">User</h1>

        @if (@Auth::user()->is_admin)
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#btnFormModal">
            + New User
        </button>
        @endif

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
                            <th class="px-3 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr id="tr_{{ $user->username }}">
                                <td class="px-3 py-2">{{ $user->username }}</td>
                                <td class="px-3 py-2">******</td>
                                {{-- Penambahan ID unik pada tag TD untuk target refresh jQuery --}}
                                <td class="px-3 py-2" id="td_email_{{ $user->username }}">{{ $user->email }}</td>
                                <td class="px-3 py-2" id="td_phone_{{ $user->username }}">{{ $user->phone_number }}</td>
                                <td class="px-3 py-2">{{ $user->is_admin }}</td>
                                <td class="px-3 py-2">{{ $user->member_id }}</td>
                                <td class="px-3 py-2">{{ $user->doctor_id }}</td>
                                <td class="px-3 py-2">{{ $user->created_at }}</td>
                                <td class="px-3 py-2" id="td_updated_{{ $user->username }}">{{ $user->updated_at }}</td>
                                <td class="px-3 py-2">
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditUser"
                                        onclick="getEditForm('{{ $user->username }}')">
                                        Update
                                    </button>
                                
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDeleteUser"
                                        onclick="prepareDelete('{{ $user->username }}')">
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
                        <label class="form-label">Username</label>
                        <input type="text" name="username" id="add_username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="add_email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" id="add_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" id="add_phone_number" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="is_admin" id="add_is_admin" class="form-control">
                            <option value="0">Regular User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                </form>
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

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" id="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" id="phone_number" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Member ID</label>
                    <input type="number" id="member_id" class="form-control" placeholder="Kosongkan jika bukan member">
                </div>

                <div class="mb-3">
                    <label class="form-label">Doctor ID</label>
                    <input type="number" id="doctor_id" class="form-control" placeholder="Kosongkan jika bukan doctor">
                </div>

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

function getEditForm(username)
{
    $.ajax({
        type: 'POST',
        url: '{{ route("user.getEditForm") }}',
        data: {
            '_token': '{{ csrf_token() }}',
            'username': username
        },

        success: function(data){
            $('#username').val(data.username);
            $('#email').val(data.email);
            $('#phone_number').val(data.phone_number);
            $('#member_id').val(data.member_id);
            $('#doctor_id').val(data.doctor_id);
            $('#password').val('');
            $('#password_confirmation').val('');
        },

        error:function(xhr){
            console.log(xhr.responseText);
        }
    });
}

function saveDataUpdate()
{
    var username = $('#username').val();
    var email = $('#email').val();
    var phone_number = $('#phone_number').val();
    var password = $('#password').val();
    var password_confirmation = $('#password_confirmation').val();
    var member_id = $('#member_id').val();
    var doctor_id = $('#doctor_id').val();

    $.ajax({
        type: 'POST',
        url: '{{ route("user.saveDataUpdate") }}', 
        data: {
            '_token': '{{ csrf_token() }}',
            'username': username,
            'email': email,
            'phone_number': phone_number,
            'password': password,
            'password_confirmation': password_confirmation,
            'member_id': member_id,
            'doctor_id': doctor_id
        },
        success: function(data) {
            if (data.status == "oke") {
                // Perbarui data di tabel secara instant (real-time)
                $('#td_email_' + username).html(email);
                $('#td_phone_' + username).html(phone_number);
                $('#td_member_' + username).html(member_id);
                $('#td_doctor_' + username).html(doctor_id);
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
function prepareDelete(username) 
{
    selectedUsernameToDelete = username;
    $('#delete_username_text').text(username);
}

// Mengeksekusi AJAX delete setelah tombol delete di dalam modal ditekan
function confirmDeleteUser() 
{
    if (!selectedUsernameToDelete) return;

    $.ajax({
        type: 'POST',
        url: '{{ route("user.deleteData") }}', 
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

function saveNewUser() 
{
    // Sembunyikan alert error di awal klik
    $('#add-user-errors').addClass('d-none').html('');

    var username = $('#add_username').val();
    var email = $('#add_email').val();
    var password = $('#add_password').val();
    var phone_number = $('#add_phone_number').val();
    var is_admin = $('#add_is_admin').val();

    $.ajax({
        type: 'POST',
        url: '{{ route("user.storeAjax") }}', // Menggunakan route khusus AJAX store
        data: {
            '_token': '{{ csrf_token() }}',
            'username': username,
            'email': email,
            'password': password,
            'phone_number': phone_number,
            'is_admin': is_admin
        },
        success: function(data) {
            if (data.status == "oke") {
                // Buat baris HTML baru untuk disuntikkan ke tabel secara instan
                var newRow = `
                    <tr id="tr_${data.user.username}">
                        <td class="px-3 py-2">${data.user.username}</td>
                        <td class="px-3 py-2">******</td>
                        <td class="px-3 py-2" id="td_email_${data.user.username}">${data.user.email}</td>
                        <td class="px-3 py-2" id="td_phone_${data.user.username}">${data.user.phone_number}</td>
                        <td class="px-3 py-2">${data.user.is_admin}</td>
                        <td class="px-3 py-2">${data.user.member_id || ''}</td>
                        <td class="px-3 py-2">${data.user.doctor_id || ''}</td>
                        <td class="px-3 py-2">${data.user.created_at}</td>
                        <td class="px-3 py-2" id="td_updated_${data.user.username}">${data.user.updated_at}</td>
                        <td class="px-3 py-2">
                            <button type="button" class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditUser" onclick="getEditForm('${data.user.username}')">Update</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteUser" onclick="prepareDelete('${data.user.username}')">Delete</button>
                        </td>
                    </tr>
                `;

                // Masukkan ke baris paling atas di dalam <tbody>
                $('table tbody').prepend(newRow);

                // Tutup modal dan reset form input
                $('#btnFormModal').modal('hide');
                $('#formAddUser')[0].reset();
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
                
                // Tampilkan pesan error di dalam modal tanpa alert popup mengganggu
                $('#add-user-errors').removeClass('d-none').html(errorList);
            } else {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan sistem saat menambah user.');
            }
        }
    });
}

</script>
@endpush