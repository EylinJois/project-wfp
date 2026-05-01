@extends('layout.app')

@section('title', 'Login | Vitaguard')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 120px);">
    <div class="col-lg-5 col-md-6">
        <div class="card surface-card">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <p class="text-uppercase text-muted mb-1 small">Login</p>
                        <h2 class="h3 mb-0">Masuk ke aplikasi</h2>
                    </div>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm">Buat akun</a>
                </div>

                <div class="form-group">
                    <label for="preset">Pilih Akun</label>
                    <select id="preset" name="preset" class="form-control">
                        <option value="">-- Pilih akun untuk testing --</option>
                        <option value="admin">Admin</option>
                        <option value="member">Member</option>
                        <option value="dokter">Dokter</option>
                    </select>
                    <small class="form-text text-muted">Pilih akun akan otomatis mengisi field login.</small>
                </div>

                <form id="login-form" action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="login">Username / Email</label>
                        <input type="text" name="login" id="login" class="form-control" value="{{ old('login') }}" autocomplete="username" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" autocomplete="current-password" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember" value="1" checked>
                            <label class="custom-control-label" for="remember">Ingat saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        // Hardcoded preset accounts for testing
        const presets = {
            admin: {
                login: 'admin@wfp.com',
                password: 'password123'
            },
            member: {
                login: 'member@wfp.com',
                password: 'password123'
            },
            dokter: {
                login: 'dokter@wfp.com',
                password: 'password123'
            }
        };

        const loginField = document.getElementById('login');
        const passwordField = document.getElementById('password');
        const presetSelect = document.getElementById('preset');
        
        // Get cookie by name
        function getCookie(name) {
            const nameEQ = name + "=";
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                let cookie = cookies[i].trim();
                if (cookie.indexOf(nameEQ) === 0) {
                    return decodeURIComponent(cookie.substring(nameEQ.length));
                }
            }
            return null;
        }
        
        // Auto-fill from remember-me cookie if exists
        const lastLogin = getCookie('wfp_last_login');
        if (lastLogin && lastLogin !== '') {
            loginField.value = lastLogin;
        }
        
        // Handle preset selection
        presetSelect.addEventListener('change', function () {
            const selectedPreset = presets[this.value];
            if (selectedPreset) {
                loginField.value = selectedPreset.login;
                passwordField.value = selectedPreset.password;
            }
        });
    })();
</script>
@endpush
