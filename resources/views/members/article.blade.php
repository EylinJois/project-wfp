@extends('layouts.adminlte4') @section('content')
    <div class="container py-5">

        <div class="row mb-5 align-items-center">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <h2 class="fw-bold" style="color: #2c3e50;">Edukasi Kesehatan</h2>
                <p class="text-muted mb-0">Temukan berbagai informasi kesehatan terpercaya yang ditulis langsung oleh tenaga
                    medis kami.</p>
            </div>
            <select name="sort" class="form-select">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="title">A-Z</option>
            </select>
            <div class="col-lg-6">
                <form action="{{ route('article.member_index') }}" method="GET" class="d-flex shadow-sm rounded">
                    <input type="text" name="search" class="form-control border-0 me-1"
                        placeholder="Cari judul artikel kesehatan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary px-4">Cari</button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @forelse($articles as $article)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden transition-hover">
                        @if ($article->photo)
                            <img src="{{ asset('storage/photos/' . $article->photo) }}" class="card-img-top"
                                alt="{{ $article->title }}" style="height: 220px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 220px;">
                                <span class="text-muted"><i class="fas fa-image fa-2x"></i><br>Tidak ada gambar</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold mb-3">{{ $article->title }}</h5>

                            <div class="d-flex text-muted small mb-3">
                                <div class="me-3">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($article->date)->format('d M Y') }}
                                </div>
                                <div>
                                    <i class="fas fa-user-md me-1"></i> dr.
                                    {{ $article->doctor ? $article->doctor->fullname : 'Anonim' }}
                                </div>
                            </div>

                            <p class="card-text text-muted mb-4">{{ Str::limit($article->content, 120) }}</p>

                            <a href="{{ route('article.show', $article->id) }}"
                                class="mt-auto btn btn-outline-primary w-100 rounded-pill">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-light rounded-3">
                        <h4 class="text-muted fw-bold">Artikel tidak ditemukan</h4>
                        <p class="text-muted">Maaf, kami tidak dapat menemukan artikel dengan judul
                            "{{ request('search') }}". Coba gunakan kata kunci lain.</p>
                        <a href="{{ route('article.member_index') }}" class="btn btn-primary mt-3">Tampilkan Semua
                            Artikel</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
