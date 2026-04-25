<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Monitoring Proyek</title>
    <link rel="icon" href="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" type="image/png">
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
        .sel {
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s ease;
            background: #f8fafc;
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.85rem center;
            background-size: 1rem;
        }
        .sel:focus {
            background-color: #fff;
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
            outline: none;
        }
        .btn-register {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            box-shadow: 0 4px 20px rgba(220,38,38,0.4);
            transition: all 0.25s ease;
        }
        .btn-register:hover:not(:disabled) {
            background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            box-shadow: 0 6px 28px rgba(220,38,38,0.55);
            transform: translateY(-1px);
        }
        .btn-register:disabled { opacity: 0.8; cursor: not-allowed; }

        /* Scrollable right panel */
        .form-scroll {
            max-height: 100vh;
            overflow-y: auto;
            scrollbar-width: none;
        }
        .form-scroll::-webkit-scrollbar { display: none; }
    </style>
</head>

<body class="min-h-screen bg-slate-900 overflow-x-hidden">

    {{-- ─── BACKGROUND (original) ─── --}}
    <div class="fixed inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-red-950"></div>
        <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-red-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 right-1/3 w-[300px] h-[300px] bg-red-700/5 rounded-full blur-2xl animate-float"></div>
    </div>

    {{-- ─── LAYOUT ─── --}}
    <div class="relative min-h-screen flex">

        {{-- ══ LEFT: Branding Panel (original) ══ --}}
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-between p-12 relative sticky top-0 h-screen">

            {{-- Top: Logo --}}
            <div>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-lg shadow-red-600/30 p-1.5">
                        <img src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom" class="w-full">
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
                    Registrasi
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-red-600">Akun Baru</span>
                </h1>
                <p class="text-slate-400 text-base leading-relaxed">
                    Daftarkan diri Anda untuk mendapatkan akses penuh ke sistem monitoring dan pengelolaan deployment.
                </p>
                {{-- Features --}}
                <div class="space-y-4 pt-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-600/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-slate-300 text-sm">Akses dashboard monitoring</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-600/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-slate-300 text-sm">Kelola data deployment</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-600/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-slate-300 text-sm">Fitur pelaporan lengkap</span>
                    </div>
                </div>
            </div>

            {{-- Bottom: Footer --}}
            <div class="text-xs text-slate-600">
                &copy; {{ date('Y') }} PT Telkom Indonesia Tbk. All rights reserved.
            </div>
        </div>

        {{-- ══ RIGHT: Register Form (new premium) ══ --}}
        <div class="w-full lg:w-1/2 form-scroll flex items-start justify-center py-8 px-5 lg:px-12">
            <div class="glass w-full max-w-[420px] rounded-3xl p-8 lg:p-9 my-auto">

                {{-- Mobile Logo --}}
                <div class="lg:hidden flex items-center gap-2.5 mb-6">
                    <div class="w-9 h-9 rounded-xl bg-white shadow border border-slate-100 flex items-center justify-center p-1">
                        <img src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom" class="w-full">
                    </div>
                    <span class="text-slate-800 font-bold text-sm">Monitoring Proyek</span>
                </div>

                {{-- Header --}}
                <div class="mb-6">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Buat Akun Baru</h2>
                    <p class="text-slate-400 text-sm mt-1.5">Isi data di bawah untuk mendaftar</p>
                </div>

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 flex items-start gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-xs text-red-700 font-medium">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="Masukkan nama lengkap"
                                class="inp w-full pl-10 pr-4 py-3 rounded-xl text-sm text-slate-800 placeholder-slate-400">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="nama@telkom.co.id"
                                class="inp w-full pl-10 pr-4 py-3 rounded-xl text-sm text-slate-800 placeholder-slate-400">
                        </div>
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Role</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </span>
                            <select name="role" required
                                class="sel w-full pl-10 pr-10 py-3 rounded-xl text-sm text-slate-800 cursor-pointer">
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="optima" {{ old('role') == 'optima' ? 'selected' : '' }}>Optima</option>
                                <option value="tif" {{ old('role') == 'tif' ? 'selected' : '' }}>TIF</option>
                                <option value="telkom_akses" {{ old('role') == 'telkom_akses' ? 'selected' : '' }}>Telkom Akses</option>
                            </select>
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
                            <input type="password" name="password" id="passInput" required
                                placeholder="Minimal 8 karakter"
                                class="inp w-full pl-10 pr-10 py-3 rounded-xl text-sm placeholder-slate-400">
                            <button type="button" id="togglePass"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <input type="password" name="password_confirmation" id="passConfirmInput" required
                                placeholder="Ulangi password"
                                class="inp w-full pl-10 pr-10 py-3 rounded-xl text-sm placeholder-slate-400">
                            <button type="button" id="togglePassConfirm"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Info note --}}
                    <div class="flex items-start gap-2 px-3 py-2.5 bg-amber-50 border border-amber-200 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        <p class="text-[11px] text-amber-700 leading-relaxed">Akun baru memerlukan persetujuan admin sebelum dapat digunakan.</p>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="registerBtn"
                        class="btn-register w-full py-3.5 rounded-xl font-bold text-white text-sm flex items-center justify-center gap-2.5 mt-1">
                        <svg id="regSpinner" class="w-4 h-4 animate-spin hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="regText">Daftar Sekarang</span>
                        <svg id="regArrow" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </form>

                {{-- Login link --}}
                <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-red-600 font-bold hover:text-red-700 transition ml-1">Masuk →</a>
                    </p>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.getElementById('togglePass').addEventListener('click', function() {
            const inp = document.getElementById('passInput');
            inp.type = inp.type === 'password' ? 'text' : 'password';
        });
        document.getElementById('togglePassConfirm').addEventListener('click', function() {
            const inp = document.getElementById('passConfirmInput');
            inp.type = inp.type === 'password' ? 'text' : 'password';
        });

        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('registerBtn');
            const spinner = document.getElementById('regSpinner');
            const text = document.getElementById('regText');
            const arrow = document.getElementById('regArrow');
            btn.disabled = true;
            spinner.classList.remove('hidden');
            arrow.classList.add('hidden');
            text.textContent = 'Mendaftar...';
        });
    </script>
</body>
</html>
