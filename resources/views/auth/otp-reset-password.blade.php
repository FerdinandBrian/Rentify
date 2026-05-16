<x-guest-layout>
    <div class="glass-card rounded-[2.5rem] p-10 border-white/10 relative overflow-hidden">
        <!-- Header -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-white mb-2">Password Baru</h2>
            <p class="text-slate-400 font-medium">Masukkan password baru untuk akun Anda</p>
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

        <form method="POST" action="{{ route('password.reset.submit') }}" class="space-y-6">
            @csrf

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">Password Baru</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-orange-500 transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" 
                        class="w-full bg-slate-900/50 border border-white/10 rounded-2xl py-4 pl-14 pr-14 text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        placeholder="Minimal 8 karakter" required autocomplete="new-password">
                    <button type="button" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-500 hover:text-orange-500 transition-colors" onclick="togglePassword(this)">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-orange-500 transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                        class="w-full bg-slate-900/50 border border-white/10 rounded-2xl py-4 pl-14 pr-5 text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        placeholder="Ulangi password" required autocomplete="new-password">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-5 rounded-2xl shadow-lg shadow-orange-500/20 transform hover:-translate-y-1 transition-all active:scale-[0.98] text-lg">
                Simpan Password
            </button>
        </form>
    </div>
</x-guest-layout>
