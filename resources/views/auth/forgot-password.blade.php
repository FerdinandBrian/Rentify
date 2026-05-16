<x-guest-layout>
    <div class="glass-card rounded-[2.5rem] p-10 border-black/5 relative overflow-hidden">
        <!-- Header -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-slate-900 mb-2">Lupa Password?</h2>
            <p class="text-slate-500 font-medium">Masukkan email Anda untuk mereset password</p>
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

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-black text-slate-500 uppercase tracking-widest ml-1">Email Address</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-500 transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                        class="w-full bg-slate-50 border border-black/5 rounded-2xl py-4 pl-14 pr-5 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        placeholder="admin@example.com" required autofocus autocomplete="username">
                </div>
                @error('email')
                    <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-5 rounded-2xl shadow-lg shadow-orange-500/20 transform hover:-translate-y-1 transition-all active:scale-[0.98] text-lg">
                Kirim Kode OTP
            </button>
        </form>

        <div class="mt-10 text-center">
            <p class="text-slate-500 font-bold">
                Ingat password Anda? 
                <a href="{{ route('login') }}" class="text-slate-900 hover:text-orange-500 transition-colors border-b border-black/5 hover:border-orange-500/50 pb-0.5 ml-1">Kembali ke login</a>
            </p>
        </div>
    </div>
</x-guest-layout>
