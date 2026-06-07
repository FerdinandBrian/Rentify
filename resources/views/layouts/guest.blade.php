<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rentify') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #f8fafc;
            background-image: radial-gradient(circle at 50% 50%, #f1f5f9 0%, #f8fafc 100%);
            min-height: 100vh;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }

        .glass-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
        }

        .glass-card:active {
            transform: translateY(-1px);
        }

        .grid-overlay {
            background-image: 
                linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px), 
                linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(circle at center, black, transparent 80%);
        }

        .form-input-focus:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.1);
        }
    </style>
</head>
<body class="antialiased text-slate-900 selection:bg-orange-500 selection:text-white overflow-x-hidden flex items-center justify-center p-4 sm:p-6">
    <div class="fixed inset-0 grid-overlay pointer-events-none"></div>
    
    <!-- Floating Orbs -->
    <div class="fixed top-20 left-20 w-72 h-72 bg-orange-500/10 rounded-full blur-[100px] animate-pulse pointer-events-none"></div>
    <div class="fixed bottom-20 right-20 w-96 h-96 bg-blue-500/10 rounded-full blur-[120px] animate-pulse pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-lg">
        <!-- Logo -->
        <div class="flex flex-col items-center mb-8 group cursor-pointer" onclick="window.location='{{ url('/') }}'">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center font-bold text-2xl shadow-xl shadow-orange-500/20 group-hover:rotate-[360deg] transition-transform duration-700">R</div>
            <span class="mt-3 font-bold text-2xl tracking-tight text-slate-900 group-hover:text-orange-500 transition-colors">Rentify</span>
        </div>

        {{ $slot }}
    </div>

    <script>
        function togglePassword(btn) {
            const input = btn.parentElement.querySelector('input');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            btn.classList.toggle('text-orange-500');
        }
    </script>
</body>
</html>
