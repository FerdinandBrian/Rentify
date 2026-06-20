<x-guest-layout>
    <div class="glass-card rounded-[2rem] p-8 border-black/5 relative overflow-hidden">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-black text-slate-900 mb-2">Selamat Datang!</h2>
            <p class="text-slate-500 font-medium">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        @if (session('status'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 px-5 py-3 rounded-2xl mb-6 text-sm font-bold text-center">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-600 px-5 py-3 rounded-2xl mb-6 text-sm font-bold text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
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
                        class="w-full bg-slate-50 border border-black/5 rounded-2xl py-3.5 pl-14 pr-5 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        placeholder="JohnDoe@example.com" required autofocus autocomplete="username">
                </div>
                @error('email')
                    <p class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="text-sm font-black text-slate-500 uppercase tracking-widest ml-1">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-500 transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" 
                        class="w-full bg-slate-50 border border-black/5 rounded-2xl py-3.5 pl-14 pr-14 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all font-bold" 
                        placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-orange-500 transition-colors" onclick="togglePassword(this)">
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

            <!-- Options -->
            <div class="flex items-center justify-between py-2">
                <label class="flex items-center cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="remember" id="remember_me" class="sr-only">
                        <div class="w-5 h-5 border-2 border-black/5 rounded-md group-hover:border-orange-500 transition-colors bg-slate-50"></div>
                        <svg class="absolute inset-0 h-5 w-5 text-orange-500 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" id="check-icon">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <span class="ml-3 text-sm font-bold text-slate-500 group-hover:text-slate-900 transition-colors">Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-orange-500 hover:text-orange-400 transition-colors">Lupa password?</a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-4 rounded-2xl shadow-lg shadow-orange-500/20 transform hover:-translate-y-1 transition-all active:scale-[0.98] text-base">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-slate-500 font-bold">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-slate-900 hover:text-orange-500 transition-colors border-b border-black/5 hover:border-orange-500/50 pb-0.5 ml-1">Daftar sekarang</a>
            </p>
        </div>
    </div>

    <script>
        const checkbox = document.getElementById('remember_me');
        const checkIcon = document.getElementById('check-icon');
        checkbox.addEventListener('change', function() {
            if(this.checked) {
                checkIcon.classList.remove('hidden');
            } else {
                checkIcon.classList.add('hidden');
            }
        });
    </script>
</x-guest-layout>
