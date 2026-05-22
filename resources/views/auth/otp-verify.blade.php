<x-guest-layout>
    <div class="glass-card rounded-[2.5rem] p-10 border-white/10 relative overflow-hidden">
        <!-- Header -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-white mb-2">Verifikasi OTP</h2>
            <p class="text-slate-400 font-medium">Masukkan 6 digit kode yang dikirim ke email Anda</p>
            <p class="text-orange-500 font-black mt-2 tracking-wide">{{ $email }}</p>
        </div>

        @if (session('status'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-6 py-4 rounded-2xl mb-8 text-sm font-bold text-center">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-6 py-4 rounded-2xl mb-8 text-sm font-bold text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify.submit') }}" id="otpForm" class="space-y-8">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="otp" id="otp_hidden">

            <div class="space-y-4">
                <div class="flex justify-between gap-2 sm:gap-4">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="text" 
                            class="otp-input-single w-12 h-14 sm:w-14 sm:h-16 bg-slate-900/50 border border-white/10 rounded-xl text-center text-xl font-black text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all" 
                            maxlength="1" 
                            oninput="moveToNext(this, event)" 
                            onkeydown="moveToPrev(this, event)" 
                            required 
                            @if($i === 0) autofocus @endif>
                    @endfor
                </div>
                @error('otp')
                    <p class="text-rose-500 text-xs font-bold mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="button" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-5 rounded-2xl shadow-lg shadow-orange-500/20 transform hover:-translate-y-1 transition-all active:scale-[0.98] text-lg" onclick="submitOtp()">
                Verifikasi Kode
            </button>
        </form>

        <div class="mt-10 text-center">
            <p class="text-slate-400 font-bold">
                Belum menerima kode? 
                <form method="POST" action="{{ route('otp.resend') }}" id="resendForm" class="inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <button type="submit" class="text-white hover:text-orange-500 transition-colors border-b border-white/10 hover:border-orange-500/50 pb-0.5 ml-1">Kirim Ulang</button>
                </form>
            </p>
        </div>
    </div>

    <script>
        function moveToNext(field, event) {
            field.value = field.value.replace(/[^0-9]/g, '');
            if (field.value.length === 1) {
                const next = field.nextElementSibling;
                if (next) {
                    next.focus();
                } else {
                    submitOtp();
                }
            }
        }

        function moveToPrev(field, event) {
            if (event.key === 'Backspace' && field.value.length === 0) {
                const prev = field.previousElementSibling;
                if (prev) {
                    prev.focus();
                    prev.value = '';
                }
            }
        }

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
