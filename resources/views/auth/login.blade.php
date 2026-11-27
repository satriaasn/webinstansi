<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ getSetting('web_name') ?: 'Bappeda Provinsi Lampung' }}</title>
    <link rel="shortcut icon" href="{{ berkas(getSetting('favicon')) ?: asset('assets/images/logo_lampung.png') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @keyframes kenBurns {
            0% { transform: scale(1) translate3d(0, 0, 0); }
            50% { transform: scale(1.07) translate3d(-1%, -1%, 0); }
            100% { transform: scale(1) translate3d(0, 0, 0); }
        }
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(-18px) translateX(10px); }
        }
        @keyframes floatReverse {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(16px) translateX(-12px); }
        }
        @keyframes cardEntrance {
            0% { opacity: 0; transform: translateY(28px) scale(0.96); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes shakeError {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        @keyframes shimmerSweep {
            0% { transform: translateX(-120%) skewX(-20deg); }
            100% { transform: translateX(220%) skewX(-20deg); }
        }

        .animate-ken-burns {
            animation: kenBurns 28s ease-in-out infinite;
        }
        .animate-float-slow {
            animation: floatSlow 8s ease-in-out infinite;
        }
        .animate-float-reverse {
            animation: floatReverse 10s ease-in-out infinite;
        }
        .animate-card-in {
            animation: cardEntrance 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .animate-shake {
            animation: shakeError 0.45s ease-in-out;
        }
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 45%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.32), transparent);
            transform: translateX(-120%) skewX(-20deg);
        }
        .btn-shine:hover::after {
            animation: shimmerSweep 0.85s ease forwards;
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#061C3D] text-slate-800 overflow-x-hidden">

    <div class="relative min-h-screen w-full flex flex-col items-center justify-center px-4 py-10 overflow-hidden">
        <!-- Animated Background Photo (Lampung Landmark) -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="{{ asset('assets/images/hero_lampung_new.jpg') }}"
                 alt="Lampung Background"
                 class="w-full h-full object-cover animate-ken-burns opacity-75">
            <!-- Blue Gradient Overlay matching reference theme -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#062454]/90 via-[#0C448C]/75 to-[#0284C7]/65"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#051B3E] via-transparent to-[#041838]/60"></div>
        </div>

        <!-- Floating Decorative Glowing Orbs -->
        <div class="pointer-events-none absolute -top-24 -left-24 w-96 h-96 rounded-full bg-sky-400/20 blur-3xl animate-float-slow z-0"></div>
        <div class="pointer-events-none absolute top-1/4 -right-24 w-80 h-80 rounded-full bg-blue-500/25 blur-3xl animate-float-reverse z-0"></div>
        <div class="pointer-events-none absolute bottom-10 left-1/3 w-72 h-72 rounded-full bg-cyan-300/15 blur-3xl animate-float-slow z-0"></div>

        <!-- Subtle Bottom Wave Accent -->
        <div class="pointer-events-none absolute bottom-0 left-0 right-0 z-0 opacity-90">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto block">
                <path d="M0,64 C320,120 640,10 960,64 C1200,104 1360,80 1440,54 L1440,120 L0,120 Z" fill="#07285C" fill-opacity="0.75"/>
                <path d="M0,88 C360,30 720,115 1080,70 C1260,48 1380,68 1440,82 L1440,120 L0,120 Z" fill="#0A3A82" fill-opacity="0.9"/>
            </svg>
        </div>

        <!-- Centered Login Card -->
        <div class="relative z-10 w-full max-w-[420px] animate-card-in">
            <!-- Top Back to Home Pill -->
            <div class="flex justify-center mb-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white text-xs font-semibold transition duration-200 hover:-translate-y-0.5 text-decoration-none shadow-sm">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            <!-- Main White Glass Card -->
            <div class="bg-white/95 backdrop-blur-xl rounded-[28px] shadow-[0_25px_60px_-15px_rgba(3,18,48,0.65)] border border-white/60 p-7 sm:p-9 {{ ($errors->any() || session('errorLogin')) ? 'animate-shake' : '' }}">

                <!-- Logo & Brand Header -->
                <div class="flex items-center justify-center gap-3.5 mb-5">
                    <img src="{{ berkas(getSetting('logo')) ?: asset('assets/images/logo_lampung.png') }}"
                         alt="{{ getSetting('web_name') ?: 'Logo Provinsi Lampung' }}"
                         onerror="this.onerror=null;this.src='{{ asset('assets/images/logo_lampung.png') }}'"
                         class="h-14 w-auto drop-shadow-sm transition-transform duration-300 hover:scale-105">
                    <div class="text-left">
                        <div class="text-xl font-black text-[#0B2545] tracking-wider leading-none">BAPPEDA</div>
                        <div class="text-xs font-bold text-[#1A56DB] tracking-wide mt-1">Provinsi Lampung</div>
                    </div>
                </div>

                <!-- Cyan-Blue Gradient Divider -->
                <div class="w-16 h-1 rounded-full bg-gradient-to-r from-[#1A56DB] via-[#0EA5E9] to-[#38BDF8] mx-auto mb-5"></div>

                <!-- Heading -->
                <div class="text-center mb-6">
                    <h1 class="text-xl font-extrabold text-[#0B2545] tracking-tight mb-1">Silakan Login</h1>
                    <p class="text-xs text-slate-500">Untuk mengakses sistem informasi &amp; pengelolaan konten</p>
                </div>

                <!-- Error Alerts -->
                @if(session('errorLogin'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-xs flex items-center gap-2.5 shadow-sm" role="alert">
                        <i class="fas fa-circle-exclamation text-red-500 text-sm flex-shrink-0"></i>
                        <span class="font-medium">{{ session('errorLogin') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-xs shadow-sm" role="alert">
                        <div class="flex items-center gap-2 font-bold mb-1">
                            <i class="fas fa-triangle-exclamation text-red-500"></i>
                            <span>Login gagal</span>
                        </div>
                        <ul class="list-disc pl-5 space-y-0.5 mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="login-form" class="space-y-4">
                    @csrf

                    <!-- Email / Username Field -->
                    <div class="group">
                        <label for="email" class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1.5 ml-1">
                            Email / Username
                        </label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-slate-400 group-focus-within:text-[#1A56DB] transition-colors duration-200 pointer-events-none">
                                <i class="fas fa-user text-sm"></i>
                            </span>
                            <input type="text"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="username"
                                   placeholder="Masukkan email atau username"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50/90 border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-[#1A56DB] focus:ring-4 focus:ring-blue-500/15 transition-all duration-200 {{ $errors->has('email') ? 'border-red-400 ring-2 ring-red-200' : '' }}">
                        </div>
                    </div>

                    <!-- Password Field with Interactive Toggle -->
                    <div class="group">
                        <label for="password" class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1.5 ml-1">
                            Password
                        </label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-slate-400 group-focus-within:text-[#1A56DB] transition-colors duration-200 pointer-events-none">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Masukkan password Anda"
                                   class="w-full pl-10 pr-11 py-3 rounded-xl bg-slate-50/90 border border-slate-200 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-[#1A56DB] focus:ring-4 focus:ring-blue-500/15 transition-all duration-200 {{ $errors->has('password') ? 'border-red-400 ring-2 ring-red-200' : '' }}">
                            <button type="button"
                                    id="toggle-password"
                                    aria-label="Tampilkan atau sembunyikan password"
                                    class="absolute right-3 w-8 h-8 rounded-lg text-slate-400 hover:text-[#1A56DB] hover:bg-blue-50 flex items-center justify-center transition-all duration-200 focus:outline-none cursor-pointer border-0 bg-transparent">
                                <i class="fas fa-eye-slash text-xs" id="toggle-password-icon"></i>
                            </button>
                        </div>
                        <div id="caps-warning" class="hidden mt-1.5 ml-1 text-[11px] font-semibold text-amber-600 flex items-center gap-1.5">
                            <i class="fas fa-circle-info"></i>
                            <span>Caps Lock sedang aktif</span>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between pt-0.5">
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none text-xs text-slate-600 hover:text-[#0B2545] transition">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-slate-300 text-[#1A56DB] focus:ring-[#1A56DB] cursor-pointer">
                            <span>Ingat saya</span>
                        </label>
                        <span class="text-[11px] text-slate-400 font-medium">Akses Terenkripsi</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            id="login-submit-btn"
                            class="btn-shine w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-[#1A56DB] via-[#0284C7] to-[#0EA5E9] hover:from-[#1344B5] hover:to-[#0284C7] text-white font-bold text-sm shadow-lg shadow-blue-600/30 hover:shadow-blue-600/45 transform hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2.5 border-0 cursor-pointer mt-2">
                        <i class="fas fa-right-to-bracket text-sm" id="login-btn-icon"></i>
                        <span id="login-btn-text">Login</span>
                    </button>
                </form>

                <!-- Siger Ornament & Card Footer -->
                <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                    <div class="flex items-center justify-center gap-2 mb-2 text-[#1A56DB]/70">
                        <span class="h-px w-10 bg-slate-200"></span>
                        <!-- Mini Siger Lampung SVG -->
                        <svg width="26" height="14" viewBox="0 0 60 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="text-[#1A56DB]">
                            <path d="M30 2 L35 16 L43 8 L46 18 L55 12 L52 26 L8 26 L5 12 L14 18 L17 8 L25 16 Z"/>
                            <rect x="10" y="28" width="40" height="2.5" rx="1.25"/>
                        </svg>
                        <span class="h-px w-10 bg-slate-200"></span>
                    </div>
                    <p class="text-[11px] font-semibold text-slate-600 mb-0.5">Bappeda Provinsi Lampung</p>
                    <p class="text-[10px] text-slate-400 mb-1">&copy; {{ date('Y') }}. Semua Hak Cipta Dilindungi.</p>
                    <p class="text-[10px] text-slate-500 font-medium m-0 flex items-center justify-center gap-1">
                        <span>Dibuat dengan</span>
                        <i class="fas fa-heart text-rose-500 animate-pulse"></i>
                        <span>oleh Bappeda</span>
                    </p>
                </div>
            </div>

            <!-- 4 Mini Interactive Feature Badges (Matching Theme Icons) -->
            <div class="mt-5 grid grid-cols-4 gap-2 text-center">
                <div class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/15 rounded-xl py-2 px-1.5 text-white transition duration-200 hover:-translate-y-0.5">
                    <i class="fas fa-chart-line text-sky-300 text-xs mb-1 block"></i>
                    <span class="text-[9px] font-semibold leading-tight block">Perencanaan</span>
                </div>
                <div class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/15 rounded-xl py-2 px-1.5 text-white transition duration-200 hover:-translate-y-0.5">
                    <i class="fas fa-lightbulb text-amber-300 text-xs mb-1 block"></i>
                    <span class="text-[9px] font-semibold leading-tight block">Inovasi</span>
                </div>
                <div class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/15 rounded-xl py-2 px-1.5 text-white transition duration-200 hover:-translate-y-0.5">
                    <i class="fas fa-handshake text-emerald-300 text-xs mb-1 block"></i>
                    <span class="text-[9px] font-semibold leading-tight block">Kolaborasi</span>
                </div>
                <div class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/15 rounded-xl py-2 px-1.5 text-white transition duration-200 hover:-translate-y-0.5">
                    <i class="fas fa-database text-blue-200 text-xs mb-1 block"></i>
                    <span class="text-[9px] font-semibold leading-tight block">Data Info</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Login Script -->
    <script>
        (function () {
            var pwdInput = document.getElementById('password');
            var toggleBtn = document.getElementById('toggle-password');
            var toggleIcon = document.getElementById('toggle-password-icon');
            var capsWarning = document.getElementById('caps-warning');
            var loginForm = document.getElementById('login-form');
            var submitBtn = document.getElementById('login-submit-btn');
            var btnIcon = document.getElementById('login-btn-icon');
            var btnText = document.getElementById('login-btn-text');

            if (toggleBtn && pwdInput) {
                toggleBtn.addEventListener('click', function () {
                    var isPassword = pwdInput.type === 'password';
                    pwdInput.type = isPassword ? 'text' : 'password';
                    toggleIcon.className = isPassword ? 'fas fa-eye text-xs text-[#1A56DB]' : 'fas fa-eye-slash text-xs';
                    pwdInput.focus();
                });
            }

            if (pwdInput && capsWarning) {
                var checkCaps = function (e) {
                    if (typeof e.getModifierState === 'function') {
                        if (e.getModifierState('CapsLock')) {
                            capsWarning.classList.remove('hidden');
                        } else {
                            capsWarning.classList.add('hidden');
                        }
                    }
                };
                pwdInput.addEventListener('keyup', checkCaps);
                pwdInput.addEventListener('keydown', checkCaps);
            }

            if (loginForm && submitBtn) {
                loginForm.addEventListener('submit', function () {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                    btnIcon.className = 'fas fa-spinner fa-spin text-sm';
                    btnText.textContent = 'Memproses...';
                });
            }
        })();
    </script>
</body>
</html>
