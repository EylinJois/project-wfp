@extends('layouts.auth')

@section('content')
<div class="login-box">
    <div class="login-logo mb-4 text-center">
        <i class="nav-icon bi bi-hospital"></i>
        <b>Vita</b>Guard
    </div>
    
    <div class="card shadow-lg border-0 overflow-hidden rounded-3">
        <div class="card-header border-0 pt-4 text-center bg-white">
            <p class="text-uppercase text-muted mb-1 small">Register</p>
            <h2 class="h4 mb-0 fw-bold">Create new account</h2>
        </div>
        
        <div class="card-body login-card-body">
            <form id="register-form" action="{{ route('register.submit') }}" method="POST">
                @csrf
              
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                </div>
          
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-block w-100 py-2 fw-bold">
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="mb-0 text-muted small">Already have an account?</p>
                <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Sign in</a>
            </div>
        </div>
    </div>
</div>
@endsection