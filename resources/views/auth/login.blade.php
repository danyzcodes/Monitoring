<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Monitoring Proyek</title>
    <link rel="icon" href="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" type="image/png">

    {{-- Preconnect to critical external origins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://www.telkom.co.id">
    <link rel="dns-prefetch" href="https://www.telkom.co.id">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-fade-in-up-delay { animation: fadeInUp 0.6s ease-out 0.15s forwards; opacity: 0; }
        .animate-fade-in-up-delay-2 { animation: fadeInUp 0.6s ease-out 0.3s forwards; opacity: 0; }

        /* ── Right form styles ── */
        .glass {
            background: rgba(255,255,255,0.97);
            box-shadow: 0 25px 60px rgba(0,0,0,0.35), 0 0 0 1px rgba(255,255,255,0.1);
        }
        .inp {
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s ease;
            background: #f8fafc;
        }
        .inp:focus {
            background: #fff;
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
            outline: none;
        }
        .btn-login {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            box-shadow: 0 4px 20px rgba(220,38,38,0.4);
            transition: all 0.25s ease;
        }
        .btn-login:hover:not(:disabled) {
            background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            box-shadow: 0 6px 28px rgba(220,38,38,0.55);
            transform: translateY(-1px);
        }
        .btn-login:disabled { opacity: 0.8; cursor: not-allowed; }
    </style>
</head>

<body class="min-h-screen bg-slate-900 overflow-hidden" data-turbo="false">

    {{-- ─── BACKGROUND (original) ─── --}}
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-red-950"></div>
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-red-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 w-[300px] h-[300px] bg-red-700/5 rounded-full blur-2xl animate-float"></div>
    </div>

    {{-- ─── LAYOUT ─── --}}
    <div class="relative min-h-screen flex">

        {{-- ══ LEFT: Branding Panel (original) ══ --}}
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-between p-12 relative">

            {{-- Top: Logo --}}
            <div>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-lg shadow-red-600/30 p-1.5">
                        <img src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom" class="w-full" fetchpriority="high" decoding="async">
                    </div>
                    <div>
                        <div class="text-white font-bold text-lg tracking-tight">Monitoring Proyek</div>
                        <div class="text-slate-400 text-xs">Unit Optima · PT Telkom Indonesia</div>
                    </div>
                </div>
            </div>

            {{-- Center: Hero Text --}}
            <div class="space-y-6 max-w-lg -mt-40">
                <h1 class="text-4xl font-extrabold text-white leading-tight">
                    Sistem
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-red-600">Monitoring</span>
                </h1>
                <p class="text-slate-400 text-base leading-relaxed">
                    Platform terpusat untuk memantau progres deployment, pengelolaan data order, dan pelaporan yang akurat bagi Unit Optima.
                </p>
                {{-- Stats --}}
                <div class="flex gap-8 pt-4">
                    <div>
                        <div class="text-2xl font-bold text-white">Data</div>
                        <div class="text-xs text-slate-500 mt-0.5">Terpusat</div>
                    </div>
                    <div class="w-px bg-slate-700"></div>
                    <div>
                        <div class="text-2xl font-bold text-white">Monitoring</div>
                        <div class="text-xs text-slate-500 mt-0.5">Real-time</div>
                    </div>
                    <div class="w-px bg-slate-700"></div>
                    <div>
                        <div class="text-2xl font-bold text-white">Laporan</div>
                        <div class="text-xs text-slate-500 mt-0.5">Otomatis</div>
                    </div>
                </div>
            </div>

            {{-- Bottom: Footer --}}
            <div class="text-xs text-slate-600">
                &copy; {{ date('Y') }} PT Telkom Indonesia Tbk. All rights reserved.
            </div>
        </div>

        {{-- ══ RIGHT: Login Form (new premium) ══ --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-5 lg:p-10">
            <div class="glass w-full max-w-[400px] rounded-3xl p-8 lg:p-9">

                {{-- Mobile Logo --}}
                <div class="lg:hidden flex items-center gap-2.5 mb-7">
                    <div class="w-9 h-9 rounded-xl bg-white shadow border border-slate-100 flex items-center justify-center p-1">
                        <img src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom" class="w-full" fetchpriority="high" decoding="async">
                    </div>
                    <span class="text-slate-800 font-bold text-sm">Monitoring Proyek</span>
                </div>

                {{-- Header --}}
                <div class="mb-7">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang </h2>
                    <p class="text-slate-400 text-sm mt-1.5">Masuk untuk mengakses dashboard</p>
                </div>

                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 flex items-start gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p class="text-xs text-red-700 font-medium">Email atau password salah. Silakan coba lagi.</p>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </span>
                            <input type="email" name="email" id="email" required autofocus
                                value="{{ old('email') }}"
                                placeholder="nama@telkom.co.id"
                                class="inp w-full pl-10 pr-4 py-3 rounded-xl text-sm text-slate-800 placeholder-slate-400">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </span>
                            <input type="password" name="password" id="passwordInput" required
                                placeholder="••••••••"
                                class="inp w-full pl-10 pr-10 py-3 rounded-xl text-sm placeholder-slate-400">
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded-md border-slate-300 text-red-600 focus:ring-red-500 focus:ring-offset-0">
                            <span class="text-sm text-slate-500 group-hover:text-slate-700 transition">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="loginBtn"
                        class="btn-login w-full mt-1 py-3.5 rounded-xl font-bold text-white text-sm flex items-center justify-center gap-2.5">
                        <svg id="btnSpinner" class="w-4 h-4 animate-spin hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="btnText">Masuk</span>
                        <svg id="btnArrow" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </form>

                {{-- Register Link --}}
                <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-400">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-red-600 font-bold hover:text-red-700 transition ml-1">Daftar Sekarang →</a>
                    </p>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const inp = document.getElementById('passwordInput');
            inp.type = inp.type === 'password' ? 'text' : 'password';
        });

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            const spinner = document.getElementById('btnSpinner');
            const text = document.getElementById('btnText');
            const arrow = document.getElementById('btnArrow');
            btn.disabled = true;
            spinner.classList.remove('hidden');
            arrow.classList.add('hidden');
            text.textContent = 'Masuk...';
        });
    </script>
</body>
</html>
