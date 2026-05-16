<x-guest-layout>
    <div class="glass-card rounded-[2.5rem] p-10 border-white/10 relative overflow-hidden">
        <!-- Header -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-white mb-2">Daftar Akun</h2>
            <p class="text-slate-400 font-medium">Lengkapi data di bawah untuk mendaftar</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-orange-500 transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                        class="w-full bg-slate-900/50 border border-white/10 rounded-2xl py-4 pl-14 pr-5 text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        placeholder="John Doe" required autofocus autocomplete="name">
                </div>
                @error('name')
                    <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

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
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                        class="w-full bg-slate-900/50 border border-white/10 rounded-2xl py-4 pl-14 pr-5 text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        placeholder="john@example.com" required autocomplete="username">
                </div>
                @error('email')
                    <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="space-y-2">
                <label for="call_number" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">Nomor Telepon</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-orange-500 transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>
                    <input type="tel" id="call_number" name="call_number" value="{{ old('call_number') }}" 
                        class="w-full bg-slate-900/50 border border-white/10 rounded-2xl py-4 pl-14 pr-5 text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        placeholder="08123456789" autocomplete="tel">
                </div>
                @error('call_number')
                    <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="password" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
                    <div class="relative group">
                        <input type="password" id="password" name="password" 
                            class="w-full bg-slate-900/50 border border-white/10 rounded-2xl py-4 px-5 text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                            placeholder="••••••••" required autocomplete="new-password">
                    </div>
                    @error('password')
                        <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-black text-slate-400 uppercase tracking-widest ml-1">Konfirmasi</label>
                    <div class="relative group">
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                            class="w-full bg-slate-900/50 border border-white/10 rounded-2xl py-4 px-5 text-white placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                            placeholder="••••••••" required autocomplete="new-password">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-5 rounded-2xl shadow-lg shadow-orange-500/20 transform hover:-translate-y-1 transition-all active:scale-[0.98] text-lg">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-10 text-center">
            <p class="text-slate-400 font-bold">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-white hover:text-orange-500 transition-colors border-b border-white/10 hover:border-orange-500/50 pb-0.5 ml-1">Masuk di sini</a>
            </p>
        </div>
    </div>
</x-guest-layout>
