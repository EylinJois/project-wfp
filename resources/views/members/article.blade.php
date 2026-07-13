@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <h1 class="mb-4">Articles</h1>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddArticle">
        + New Article
    </button>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Title</th>
                        <th class="px-3 py-2">Date</th>
                        <th class="px-3 py-2">Photo</th>
                        <th class="px-3 py-2">Doctor</th>
                        <th class="px-3 py-2">Content</th>
                        <th class="px-3 py-2">Created</th>
                        <th class="px-3 py-2">Updated</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                    <tr id="tr_article_{{ $article->id }}">
                        <td class="px-3 py-2">{{ $article->id }}</td>
                        <td class="px-3 py-2" id="td_title_{{ $article->id }}">{{ $article->title }}</td>
                        <td class="px-3 py-2" id="td_date_{{ $article->id }}">{{ $article->date }}</td>
                        <td class="px-3 py-2" id="td_photo_{{ $article->id }}">
                            @if ($article->photo)
                                <img src="{{ asset('storage/photos/'.$article->photo) }}" alt="photo" width="60">
                            @endif
                        </td>
                        <td class="px-3 py-2" id="td_doctor_{{ $article->id }}">{{ $article->doctor->fullname ?? '-' }}</td>
                        <td class="px-3 py-2" id="td_content_{{ $article->id }}">{{ Str::limit($article->content, 80) }}</td>
                        <td class="px-3 py-2">{{ $article->created_at }}</td>
                        <td class="px-3 py-2" id="td_updated_{{ $article->id }}">{{ $article->updated_at }}</td>
                        <td class="px-3 py-2">
                            <button
                                type="button"
                                class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditArticle"
                                onclick="getEditForm({{ $article->id }})">
                                Update
                            </button>

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDeleteArticle"
                                onclick="prepareDelete({{ $article->id }}, '{{ addslashes($article->title) }}')">
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
<div class="modal fade" id="modalAddArticle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Article</h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger d-none" id="add-article-errors"></div>

                <form id="formAddArticle" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="add_title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" id="add_date" class="form-control" required>
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
                        <label class="form-label">Content</label>
                        <textarea name="content" id="add_content" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Photo (optional)</label>
                        <input type="file" name="photo" id="add_photo" class="form-control" accept="image/*">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveNewArticle()">Save Article</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditArticle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Article</h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger d-none" id="edit-article-errors"></div>

                <form id="formEditArticle" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" id="edit_title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" id="edit_date" class="form-control" required>
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
                        <label class="form-label">Content</label>
                        <textarea id="edit_content" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Photo</label><br>
                        <img id="edit_current_photo" src="" alt="" width="80" class="mb-2 d-none">
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

<div class="modal fade" id="modalDeleteArticle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Article</h4>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this article?</p>
                <p class="fw-bold mt-2" id="delete_article_text"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="confirmDeleteArticle()">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>

function saveNewArticle()
{
    $('#add-article-errors').addClass('d-none').html('');

    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('title', $('#add_title').val());
    formData.append('date', $('#add_date').val());
    formData.append('doctor_id', $('#add_doctor_id').val());
    formData.append('content', $('#add_content').val());

    var photoFile = $('#add_photo')[0].files[0];
    if (photoFile) {
        formData.append('photo', photoFile);
    }

    $.ajax({
        type: 'POST',
        url: '{{ route("article.storeAjax") }}',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.status == "oke") {
                var a = data.article;
                var photoHtml = a.photo_url ? `<img src="${a.photo_url}" alt="photo" width="60">` : '';

                var newRow = `
                    <tr id="tr_article_${a.id}">
                        <td class="px-3 py-2">${a.id}</td>
                        <td class="px-3 py-2" id="td_title_${a.id}">${a.title}</td>
                        <td class="px-3 py-2" id="td_date_${a.id}">${a.date}</td>
                        <td class="px-3 py-2" id="td_photo_${a.id}">${photoHtml}</td>
                        <td class="px-3 py-2" id="td_doctor_${a.id}">${a.doctor_name}</td>
                        <td class="px-3 py-2" id="td_content_${a.id}">${a.content.substring(0, 80)}</td>
                        <td class="px-3 py-2">${a.created_at}</td>
                        <td class="px-3 py-2" id="td_updated_${a.id}">${a.updated_at}</td>
                        <td class="px-3 py-2">
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditArticle" onclick="getEditForm(${a.id})">Update</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteArticle" onclick="prepareDelete(${a.id}, '${a.title}')">Delete</button>
                        </td>
                    </tr>
                `;

                $('table tbody').prepend(newRow);

                $('#modalAddArticle').modal('hide');
                $('#formAddArticle')[0].reset();
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
                $('#add-article-errors').removeClass('d-none').html(errorList);
            } else {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan sistem saat menambah artikel.');
            }
        }
    });
}

function getEditForm(id)
{
    $('#edit-article-errors').addClass('d-none').html('');

    $.ajax({
        type: 'POST',
        url: '{{ route("article.getEditForm") }}',
        data: {
            '_token': '{{ csrf_token() }}',
            'id': id
        },
        success: function(data) {
            $('#edit_id').val(data.id);
            $('#edit_title').val(data.title);
            $('#edit_date').val(data.date);
            $('#edit_doctor_id').val(data.doctor_id);
            $('#edit_content').val(data.content);
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

function saveDataUpdate()
{
    $('#edit-article-errors').addClass('d-none').html('');

    var id = $('#edit_id').val();

    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('id', id);
    formData.append('title', $('#edit_title').val());
    formData.append('date', $('#edit_date').val());
    formData.append('doctor_id', $('#edit_doctor_id').val());
    formData.append('content', $('#edit_content').val());

    var photoFile = $('#edit_photo')[0].files[0];
    if (photoFile) {
        formData.append('photo', photoFile);
    }

    $.ajax({
        type: 'POST',
        url: '{{ route("article.saveDataUpdate") }}',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.status == "oke") {
                $('#td_title_' + id).html(data.title);
                $('#td_date_' + id).html(data.date);
                $('#td_doctor_' + id).html(data.doctor_name);
                $('#td_content_' + id).html(data.content.substring(0, 80));
                $('#td_updated_' + id).html(data.updated_at);

                if (data.photo_url) {
                    $('#td_photo_' + id).html('<img src="' + data.photo_url + '" alt="photo" width="60">');
                }

                $('#modalEditArticle').modal('hide');
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
                $('#edit-article-errors').removeClass('d-none').html(errorList);
            } else {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan sistem saat mengupdate artikel.');
            }
        }
    });
}

var selectedArticleIdToDelete = '';

function prepareDelete(id, title)
{
    selectedArticleIdToDelete = id;
    $('#delete_article_text').text(title);
}

function confirmDeleteArticle()
{
    if (!selectedArticleIdToDelete) return;

    $.ajax({
        type: 'POST',
        url: '{{ route("article.deleteData") }}',
        data: {
            '_token': '{{ csrf_token() }}',
            'id': selectedArticleIdToDelete
        },
        success: function(data) {
            if (data.status == "oke") {
                $('#tr_article_' + selectedArticleIdToDelete).remove();
                $('#modalDeleteArticle').modal('hide');
                selectedArticleIdToDelete = '';
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