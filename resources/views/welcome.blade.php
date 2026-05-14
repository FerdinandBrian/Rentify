<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rentify - Premium Car Rental</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                        },
                        animation: {
                            'shimmer': 'shimmer 3s infinite linear',
                            'float': 'float 6s ease-in-out infinite',
                        },
                        keyframes: {
                            shimmer: {
                                '0%': { backgroundPosition: '-200% 0' },
                                '100%': { backgroundPosition: '200% 0' },
                            },
                            float: {
                                '0%, 100%': { transform: 'translateY(0)' },
                                '50%': { transform: 'translateY(-20px)' },
                            }
                        }
                    }
                }
            }
        </script>

        <style>
            body { font-family: 'Outfit', sans-serif; background-color: #020617; }
            
            .glass-nav {
                background: rgba(2, 6, 23, 0.7);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }

            .glass-card {
                background: rgba(15, 23, 42, 0.4);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            }

            .hero-bg {
                background: radial-gradient(circle at 50% 50%, #1e1b4b 0%, #020617 100%);
            }

            .grid-overlay {
                background-image: 
                    linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), 
                    linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
                background-size: 60px 60px;
                mask-image: radial-gradient(circle at center, black, transparent 80%);
            }

            .text-shimmer {
                background: linear-gradient(90deg, #f97316, #fbbf24, #f97316);
                background-size: 200% auto;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: shimmer 4s linear infinite;
            }

            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
            }

            .reveal.active {
                opacity: 1;
                transform: translateY(0);
            }

            .parallax-element {
                will-change: transform;
            }
        </style>
    </head>
    <body class="antialiased text-slate-100 selection:bg-orange-500 selection:text-white overflow-x-hidden">

        <!-- Navigation -->
        <nav class="fixed w-full z-50 transition-all duration-500" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-24 transition-all duration-500" id="nav-content">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer group">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center font-bold text-2xl shadow-xl shadow-orange-500/20 group-hover:rotate-[360deg] transition-transform duration-700">R</div>
                        <span class="font-bold text-2xl tracking-tight text-white group-hover:text-orange-400 transition-colors">Rentify</span>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-10">
                        @foreach(['Home', 'Armada Mobil', 'Layanan', 'Testimoni'] as $item)
                            <a href="#" class="text-slate-400 hover:text-white font-semibold transition-all duration-300 relative group">
                                {{ $item }}
                                <span class="absolute -bottom-2 left-0 w-0 h-1 bg-gradient-to-r from-orange-500 to-yellow-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
                            </a>
                        @endforeach
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="relative group overflow-hidden bg-white/5 hover:bg-white/10 text-white px-8 py-3 rounded-full transition-all duration-300 border border-white/10">
                                    <span class="relative z-10 font-bold">Dashboard</span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-yellow-500 opacity-0 group-hover:opacity-20 transition-opacity"></div>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-slate-400 hover:text-white font-bold transition-colors hidden sm:block">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:scale-105 active:scale-95 text-white px-8 py-3.5 rounded-full font-extrabold transition-all duration-300 shadow-2xl shadow-orange-500/30">
                                        Sign Up
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative min-h-screen flex items-center justify-center hero-bg overflow-hidden pt-20">
            <!-- Parallax Grid -->
            <div class="absolute inset-0 grid-overlay parallax-element" data-depth="0.1"></div>

            <!-- Floating Orbs -->
            <div class="absolute top-20 left-20 w-72 h-72 bg-orange-500/10 rounded-full blur-[100px] animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-blue-500/10 rounded-full blur-[120px] animate-pulse"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center justify-between gap-20 w-full py-12">
                
                <!-- Text Content -->
                <div class="w-full lg:w-3/5 flex flex-col items-center lg:items-start text-center lg:text-left">
                    <div class="reveal active inline-flex items-center gap-3 px-6 py-2.5 rounded-full bg-white/5 border border-white/10 text-orange-400 text-sm font-bold mb-8 backdrop-blur-xl">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-orange-500 animate-ping"></span>
                        Premium Experience Only
                    </div>
                    
                    <h1 class="reveal active text-6xl sm:text-7xl lg:text-8xl font-black tracking-tighter mb-8 leading-[0.9] text-white">
                        Drive the <br/>
                        <span class="text-shimmer">Future.</span>
                    </h1>
                    
                    <p class="reveal active text-slate-400 text-xl sm:text-2xl mb-12 max-w-2xl leading-relaxed font-medium">
                        Koleksi mobil eksklusif untuk gaya hidup modern Anda. Sewa sekarang dengan sistem instan dan keamanan maksimal.
                    </p>
                    
                    <div class="reveal active flex flex-col sm:flex-row gap-6 w-full sm:w-auto">
                        <a href="{{ route('register') ?? '#' }}" class="relative group bg-orange-500 text-white px-10 py-5 rounded-2xl font-black transition-all duration-300 hover:shadow-[0_20px_50px_rgba(249,115,22,0.4)] hover:-translate-y-2 flex items-center justify-center gap-3 text-xl overflow-hidden">
                            <span class="relative z-10">Mulai Sewa Sekarang</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-yellow-500 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        </a>
                        <a href="#armada" class="glass-card hover:bg-white/10 text-white px-10 py-5 rounded-2xl font-black transition-all duration-300 hover:-translate-y-2 flex items-center justify-center text-xl">
                            Eksplorasi Mobil!
                        </a>
                    </div>
                    
                    <!-- Stats Grid -->
                    <div class="reveal active mt-16 grid grid-cols-2 sm:grid-cols-3 gap-12 w-full pt-10 border-t border-white/5">
                        @foreach([['500+', 'Premium Cars'], ['12K+', 'Happy Users'], ['4.9', 'App Rating']] as $stat)
                        <div class="group">
                            <h3 class="text-4xl font-black text-white group-hover:text-orange-400 transition-colors">{{ $stat[0] }}</h3>
                            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs mt-2">{{ $stat[1] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- 3D Car Card -->
                <div class="w-full lg:w-2/5 relative reveal active">
                    <div id="car-card" class="relative car-image-container group cursor-pointer transition-all duration-500 ease-out">
                        <!-- Glow effect -->
                        <div class="absolute inset-0 bg-orange-500/20 rounded-[2.5rem] blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <div class="relative glass-card p-4 rounded-[2.5rem] overflow-hidden border-white/20">
                            <div class="rounded-[2rem] overflow-hidden relative bg-slate-900 group">
                                <img src="{{ asset('images/hero-car.png') }}" alt="Porsche 911" class="w-full h-auto object-cover transform scale-110 group-hover:scale-125 transition-transform duration-1000">
                                
                                <!-- Glass Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-90 group-hover:opacity-70 transition-opacity"></div>
                                
                                <!-- Floating Label -->
                                <div class="absolute top-6 right-6 bg-orange-500 text-white text-xs font-black px-4 py-2 rounded-full uppercase tracking-widest animate-pulse">
                                    New Arrival
                                </div>

                                <!-- Card Content -->
                                <div class="absolute bottom-10 left-10 right-10">
                                    <p class="text-orange-400 text-sm font-black mb-2 uppercase tracking-[0.3em]">Signature Collection</p>
                                    <h2 class="text-4xl font-black text-white mb-6">Porsche 911 <br/> Carrera S</h2>
                                    
                                    <div class="flex items-center justify-between pt-6 border-t border-white/10">
                                        <div>
                                            <p class="text-slate-400 text-xs font-bold uppercase">Mulai Dari</p>
                                            <p class="text-2xl font-black text-white">Rp 5.5 jt<span class="text-sm font-medium text-slate-500">/hari</span></p>
                                        </div>
                                        <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center group-hover:bg-orange-500 transition-colors duration-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>

        <script>
            // Navbar Scroll Styling
            window.addEventListener('scroll', () => {
                const nav = document.getElementById('navbar');
                const content = document.getElementById('nav-content');
                if (window.scrollY > 50) {
                    nav.classList.add('glass-nav');
                    content.classList.replace('h-24', 'h-20');
                } else {
                    nav.classList.remove('glass-nav');
                    content.classList.replace('h-20', 'h-24');
                }
            });

            // Parallax Grid Effect
            window.addEventListener('mousemove', (e) => {
                const elements = document.querySelectorAll('.parallax-element');
                const x = (e.clientX - window.innerWidth / 2) * 0.01;
                const y = (e.clientY - window.innerHeight / 2) * 0.01;

                elements.forEach(el => {
                    const depth = el.getAttribute('data-depth') || 0.1;
                    gsap.to(el, {
                        x: x * depth * 50,
                        y: y * depth * 50,
                        duration: 1,
                        ease: 'power2.out'
                    });
                });
            });

            // 3D Card Tilt Effect
            const card = document.getElementById('car-card');
            if(card) {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = (y - centerY) / 20;
                    const rotateY = (centerX - x) / 20;
                    
                    gsap.to(card, {
                        rotateX: rotateX,
                        rotateY: rotateY,
                        scale: 1.05,
                        duration: 0.5,
                        ease: 'power2.out'
                    });
                });

                card.addEventListener('mouseleave', () => {
                    gsap.to(card, {
                        rotateX: 0,
                        rotateY: 0,
                        scale: 1,
                        duration: 0.5,
                        ease: 'power2.out'
                    });
                });
            }

            // Reveal animations on scroll (simple backup)
            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        </script>
    </body>
</html>
