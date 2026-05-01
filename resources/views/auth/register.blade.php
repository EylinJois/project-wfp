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

                <div class="form-group">
                    <label for="preset">Preset akun</label>
                    <select id="preset" name="preset" class="form-control" form="register-form">
                        @foreach ($presets as $key => $preset)
                            <option value="{{ $key }}" @selected(old('preset', $selectedPreset) === $key)>{{ $preset['label'] }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Preset hanya mengisi field awal, tetap bisa diedit manual.</small>
                </div>

                <form id="register-form" action="{{ route('register.submit') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $prefill['username']) }}" autocomplete="username" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $prefill['email']) }}" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control" value="{{ old('nomor_telepon', $prefill['nomor_telepon']) }}" autocomplete="tel" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" value="{{ old('password', $prefill['password']) }}" autocomplete="new-password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{ old('password_confirmation', $prefill['password']) }}" autocomplete="new-password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">Buat akun dan masuk</button>
                </form>

                <div class="mt-4 pt-3 border-top">
                    <div class="small text-muted">Setelah submit, user langsung login memakai session dan cookie preset terakhir akan disimpan.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const presets = @json($presets);
        const presetSelect = document.getElementById('preset');
        const usernameField = document.getElementById('username');
        const emailField = document.getElementById('email');
        const phoneField = document.getElementById('nomor_telepon');
        const passwordField = document.getElementById('password');
        const confirmationField = document.getElementById('password_confirmation');

        function applyPreset(value) {
            const preset = presets[value];
            if (!preset) {
                return;
            }

            usernameField.value = preset.username;
            emailField.value = preset.email;
            phoneField.value = preset.nomor_telepon;
            passwordField.value = preset.password;
            confirmationField.value = preset.password;
        }

        presetSelect.addEventListener('change', function () {
            applyPreset(this.value);
        });

        applyPreset(presetSelect.value);
    })();
</script>
@endpush
