<x-guest-layout>
    <div class="login-card">
        <div class="login-header">
            <div class="neu-icon">
                <div class="icon-inner">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
            </div>
            <h2>Lupa Password?</h2>
            <p>Masukkan email Anda untuk mereset password</p>
        </div>

        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="status-message error">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group @error('email') error @enderror">
                <div class="neu-input">
                    <div class="input-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder=" " required autofocus autocomplete="username">
                    <label for="email">Email</label>
                </div>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="neu-button">
                <span class="btn-text">Kirim Kode OTP</span>
            </button>
        </form>

        <div class="signup-link">
            <p>Ingat password Anda? <a href="{{ route('login') }}">Kembali ke login</a></p>
        </div>
    </div>
</x-guest-layout>
