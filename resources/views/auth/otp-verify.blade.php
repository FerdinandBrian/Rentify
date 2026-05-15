<x-guest-layout>
    <div class="login-card">
        <div class="login-header">
            <div class="neu-icon">
                <div class="icon-inner">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        <path d="M9 12l2 2 4-4"></path>
                    </svg>
                </div>
            </div>
            <h2>Verifikasi OTP</h2>
            <p>Masukkan 6 digit kode yang dikirim ke email Anda</p>
            <p style="font-weight: 700; color: #1a2035; margin-top: 5px;">{{ $email }}</p>
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

        <form method="POST" action="{{ route('otp.verify.submit') }}" id="otpForm">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="otp" id="otp_hidden">

            <div class="form-group @error('otp') error @enderror">
                <div class="otp-inputs">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="neu-input" style="border-radius: 10px;">
                            <input type="text" class="otp-input-single" maxlength="1" oninput="moveToNext(this, event)" onkeydown="moveToPrev(this, event)" placeholder=" " required autofocus="{{ $i === 0 ? 'true' : 'false' }}">
                        </div>
                    @endfor
                </div>
                @error('otp')
                    <span class="error-message" style="text-align: center; margin-left: 0;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit -->
            <button type="button" class="neu-button" onclick="submitOtp()">
                <span class="btn-text">Verifikasi</span>
            </button>
        </form>

        <div class="signup-link">
            <p>Belum menerima kode? 
                <form method="POST" action="{{ route('otp.resend') }}" id="resendForm" style="display: inline;">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <button type="submit" id="resendBtn" style="background:none; border:none; color:#1572e8; font-weight:700; cursor:pointer; font-size:14px;">Kirim Ulang</button>
                </form>
            </p>
        </div>
    </div>

    <script>
        function moveToNext(field, event) {
            // Allow only numbers
            field.value = field.value.replace(/[^0-9]/g, '');
            
            if (field.value.length === 1) {
                const next = field.parentElement.nextElementSibling;
                if (next && next.classList.contains('neu-input')) {
                    next.querySelector('input').focus();
                } else if (!next) {
                    submitOtp();
                }
            }
        }

        function moveToPrev(field, event) {
            if (event.key === 'Backspace' && field.value.length === 0) {
                const prev = field.parentElement.previousElementSibling;
                if (prev && prev.classList.contains('neu-input')) {
                    const prevInput = prev.querySelector('input');
                    prevInput.focus();
                    prevInput.value = '';
                }
            }
        }

        // Paste support
        document.querySelector('.otp-inputs').addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            const inputs = document.querySelectorAll('.otp-input-single');
            
            for (let i = 0; i < pastedData.length; i++) {
                if (inputs[i]) {
                    inputs[i].value = pastedData[i];
                    if (i < 5) inputs[i + 1].focus();
                    else inputs[i].focus();
                }
            }
            if (pastedData.length === 6) {
                submitOtp();
            }
        });

        function submitOtp() {
            const inputs = document.querySelectorAll('.otp-input-single');
            let otpCode = '';
            let isComplete = true;
            
            inputs.forEach(input => {
                otpCode += input.value;
                if (!input.value) isComplete = false;
            });
            
            if (isComplete && otpCode.length === 6) {
                document.getElementById('otp_hidden').value = otpCode;
                document.getElementById('otpForm').submit();
            }
        }
    </script>
</x-guest-layout>
