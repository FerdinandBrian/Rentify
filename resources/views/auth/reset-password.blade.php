<x-guest-layout>
    <div class="glass-card rounded-[2.5rem] p-10 border-white/10 relative overflow-hidden">
        <!-- Header -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-white mb-2">Reset Password</h2>
            <p class="text-slate-400 font-medium">Buat password baru yang kuat untuk akun Anda</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-orange-500 transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" 
                        class="w-full bg-slate-900/50 border border-white/10 rounded-2xl py-4 pl-14 pr-5 text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        required autofocus autocomplete="username">
                </div>
                @error('email')
                    <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

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
                <label for="password_confirmation" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-orange-500 transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                        class="w-full bg-slate-900/50 border border-white/10 rounded-2xl py-4 pl-14 pr-5 text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        placeholder="Ulangi password baru" required autocomplete="new-password">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-5 rounded-2xl shadow-lg shadow-orange-500/20 transform hover:-translate-y-1 transition-all active:scale-[0.98] text-lg">
                Reset Password
            </button>
        </form>

        <div class="mt-10 text-center">
            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-400 hover:text-orange-500 transition-colors">← Kembali ke login</a>
        </div>
    </div>
</x-guest-layout>
