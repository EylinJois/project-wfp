@extends('layouts.adminlte4')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Artikel Kesehatan</h1>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateArticle">
        
            <i class="fas fa-plus"></i> Tambah Artikel</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Judul (Title)</th>
                        <th class="px-3 py-2">Tanggal</th>
                        <th class="px-3 py-2">Konten</th>
                        <th class="px-3 py-2">Foto</th>
                        <th class="px-3 py-2">Penulis (Dokter)</th>
                        @if(Auth::user()->is_admin)
                        <th class="px-3 py-2">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td class="px-3 py-2">{{ $article->id }}</td>
                            <td class="px-3 py-2">{{ $article->title }}</td>
                            <td class="px-3 py-2">{{ $article->date }}</td>
                            <td class="px-3 py-2">{{ Str::limit($article->content, 50) }}</td>
                            <td class="px-3 py-2">
                                @if($article->photo)
                                    <img src="{{ asset('storage/photos/'.$article->photo) }}" alt="foto" width="60" class="img-thumbnail">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>
                            <td class="px-3 py-2">{{ $article->doctor ? $article->doctor->fullname : 'N/A' }}</td>
                            @if(Auth::user()->is_admin)
                            <td class="px-3 py-2 text-center">
                                <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="{{ $article->id }}">
                                    Edit
                                </button>
                                
                                <form action="{{ route('article.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreateArticle" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateLabel">Tambah Artikel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal Terbit</label>
                        <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Penulis (Dokter)</label>
                        <select class="form-select" name="doctor_id" required>
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Artikel</label>
                        <textarea class="form-control" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Artikel</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditArticle" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditArticle" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Artikel Kesehatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Judul Artikel</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_date" class="form-label">Tanggal Terbit</label>
                        <input type="date" class="form-control" id="edit_date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_doctor_id" class="form-label">Penulis (Dokter)</label>
                        <select class="form-select" id="edit_doctor_id" name="doctor_id" required>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_content" class="form-label">Isi Artikel</label>
                        <textarea class="form-control" id="edit_content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_photo" class="form-label">Ubah Foto Artikel (Biarkan kosong jika tidak diganti)</label>
                        <input type="file" class="form-control" id="edit_photo" name="photo" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-edit').on('click', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: '/admin/article/' + id + '/edit',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var article = response.data;
                
                $('#edit_title').val(article.title);
                $('#edit_date').val(article.date);
                $('#edit_doctor_id').val(article.doctor_id);
                $('#edit_content').val(article.content);
                
                $('#formEditArticle').attr('action', '/admin/article/' + id);
                
                $('#modalEditArticle').modal('show');
            },
            error: function() {
                alert('Gagal mengambil data dari server.');
            }
        });
    });
});
</script>
@endsection