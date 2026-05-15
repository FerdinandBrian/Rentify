<x-guest-layout>
    <div class="login-card">
        <div class="login-header">
            <div class="neu-icon">
                <div class="icon-inner">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
            </div>
            <h2>Verifikasi Email</h2>
            <p>Silakan cek inbox Anda untuk link verifikasi</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="status-message">
                Link verifikasi baru telah dikirim ke email yang Anda gunakan saat registrasi.
            </div>
        @endif

        <div style="display: flex; gap: 1rem; flex-direction: column;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="neu-button" style="margin-bottom: 15px;">
                    <span class="btn-text">Kirim Ulang Email</span>
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="neu-button" style="box-shadow: inset 4px 4px 10px #bec3cf, inset -4px -4px 10px #ffffff; color: #f25961; margin-bottom: 0;">
                    <span class="btn-text">Logout</span>
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
