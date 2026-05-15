<x-guest-layout>
    <div class="auth-wrapper">
        <!-- Left Panel - Branding -->
        <div class="auth-branding">
            <div class="brand-content">
                <div class="brand-logo">
                    <div class="brand-logo-icon">
                        <i data-lucide="car"></i>
                    </div>
                    <span class="brand-logo-text">Rentify</span>
                </div>
                <h1 class="brand-headline">
                    Reset<br><span>Password</span>
                </h1>
                <p class="brand-desc">
                    Buat password baru yang kuat untuk akun Anda. Gunakan kombinasi huruf, angka, dan simbol.
                </p>
            </div>

            <div class="brand-features">
                <div class="brand-feature">
                    <div class="brand-feature-icon blue">
                        <i data-lucide="lock-keyhole"></i>
                    </div>
                    <span>Minimal 8 Karakter</span>
                </div>
                <div class="brand-feature">
                    <div class="brand-feature-icon amber">
                        <i data-lucide="text-cursor-input"></i>
                    </div>
                    <span>Kombinasi Huruf & Angka</span>
                </div>
                <div class="brand-feature">
                    <div class="brand-feature-icon green">
                        <i data-lucide="shield-check"></i>
                    </div>
                    <span>Enkripsi Aman</span>
                </div>
            </div>
        </div>

        <!-- Right Panel - Reset Form -->
        <div class="auth-form-panel">
            <div class="auth-form-header">
                <h2>Password Baru 🔑</h2>
                <p>Buat password baru untuk akun Anda</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="form-input-wrapper">
                        <input
                            id="email"
                            class="form-input"
                            type="email"
                            name="email"
                            value="{{ old('email', $request->email) }}"
                            required
                            autofocus
                            autocomplete="username"
                        >
                        <i data-lucide="mail"></i>
                    </div>
                    @error('email')
                        <div class="form-error">
                            <i data-lucide="alert-circle" style="width:14px;height:14px;"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">Password Baru</label>
                    <div class="form-input-wrapper">
                        <input
                            id="password"
                            class="form-input"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                        >
                        <i data-lucide="lock"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                            <i data-lucide="eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="form-error">
                            <i data-lucide="alert-circle" style="width:14px;height:14px;"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="form-input-wrapper">
                        <input
                            id="password_confirmation"
                            class="form-input"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi password baru"
                        >
                        <i data-lucide="shield-check"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                            <i data-lucide="eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="form-error">
                            <i data-lucide="alert-circle" style="width:14px;height:14px;"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-primary">
                    Reset Password
                </button>
            </form>

            <div class="auth-footer">
                <a href="{{ route('login') }}">← Kembali ke login</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i, [data-lucide]');
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</x-guest-layout>
