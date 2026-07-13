
@extends('layouts.auth')

@section('content')
<div class="login-box">
    <div class="login-logo mb-4 text-center">
        <i class="nav-icon bi bi-hospital"></i>
        <b>Vita</b>Guard
    </div>
    
    <div class="card shadow-lg border-0 overflow-hidden rounded-3">
        <div class="card-header border-0 pt-4 text-center bg-white">
            <p class="text-uppercase text-muted mb-1 small">Sign In</p>
            <h2 class="h4 mb-0 fw-bold">Sign in to the app</h2>
        </div>
        
        <div class="card-body login-card-body">

            <div class="mb-4 p-3 bg-warning rounded border">
                <label for="preset" class="form-label text-xs fw-bold">Choose a test account</label>
                <div class="input-group input-group-sm">
                    <select id="preset" name="preset" class="form-select">
                        <option value="">-- Role --</option>
                        <option value="admin">Admin</option>
                        <option value="member">Member</option>
                        <option value="dokter">Dokter</option>
                    </select>
                </div>
            </div>

            <form id="login-form" action="{{ route('login.submit') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="login" class="form-label">Username</label>
                    <div class="input-group">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="{{ old('login') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-block w-100 py-2 fw-bold">Sign in</button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="mb-0 text-muted small">Don't have an account?</p>
                <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Create new account</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const presets = {
            admin: {
                username: 'admin',
                password: 'pwa'
            },
            member: {
                username: 'member',
                password: 'pwm'
            },
            dokter: {
                username: 'dokter',
                password: 'pwd'
            }
        };

        const usernameField = document.getElementById('username');
        const passwordField = document.getElementById('password');
        const presetSelect = document.getElementById('preset');
        
        presetSelect.addEventListener('change', function () {
            const selectedPreset = presets[this.value];
            if (selectedPreset) {
                usernameField.value = selectedPreset.username;
                passwordField.value = selectedPreset.password;
            } else {
                usernameField.value = '';
                passwordField.value = '';
            }
        });
    })();
</script>
@endpush