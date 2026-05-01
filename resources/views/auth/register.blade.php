@extends('layout.app')

@section('title', 'Register | Vitaguard')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 120px);">
    <div class="col-lg-5 col-md-6">
        <div class="card surface-card">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <p class="text-uppercase text-muted mb-1 small">Register</p>
                        <h2 class="h3 mb-0">Buat akun baru</h2>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Sudah punya akun</a>
                </div>

                <form id="register-form" action="{{ route('register.submit') }}" method="POST">
                    @csrf

                  
                    <div class="form-group ">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" autocomplete="username" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" autocomplete="email" required>
                    </div>
                 
                    <div class="form-group">
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control" value="{{ old('nomor_telepon') }}" autocomplete="tel" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" autocomplete="new-password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" autocomplete="new-password" required>
                    </div>
              
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Buat akun dan masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
