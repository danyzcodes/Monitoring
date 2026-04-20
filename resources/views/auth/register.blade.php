<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Monitoring Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-fade-in-up-delay { animation: fadeInUp 0.6s ease-out 0.15s forwards; opacity: 0; }
        .animate-fade-in-up-delay-2 { animation: fadeInUp 0.6s ease-out 0.3s forwards; opacity: 0; }

        .input-field {
            transition: all 0.3s ease;
            border: 1.5px solid #e2e8f0;
        }
        .input-field:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.35);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .select-field {
            transition: all 0.3s ease;
            border: 1.5px solid #e2e8f0;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1rem;
        }
        .select-field:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
    </style>
</head>

<body class="min-h-screen bg-slate-900 overflow-hidden">

    <!-- BACKGROUND PATTERN -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-red-950"></div>
        <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-red-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 right-1/3 w-[300px] h-[300px] bg-red-700/5 rounded-full blur-2xl animate-float"></div>
    </div>

    <!-- CONTENT -->
    <div class="relative min-h-screen flex">

        <!-- LEFT PANEL: Branding -->
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-between p-12 relative">

            <!-- Top: Logo -->
            <div class="animate-fade-in-up">
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

            <!-- Center: Hero Text -->
            <div class="animate-fade-in-up-delay space-y-6 max-w-lg">
                <h1 class="text-4xl font-extrabold text-white leading-tight">
                    Registrasi
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-red-600">Akun Baru</span>
                </h1>
                <p class="text-slate-400 text-base leading-relaxed">
                    Daftarkan diri Anda untuk mendapatkan akses penuh ke sistem monitoring dan pengelolaan deployment.
                </p>

                <!-- Features -->
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

            <!-- Bottom: Footer -->
            <div class="animate-fade-in-up-delay-2 text-xs text-slate-600">
                &copy; {{ date('Y') }} PT Telkom Indonesia Tbk. All rights reserved.
            </div>
        </div>

        <!-- RIGHT PANEL: Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            <div class="glass-card w-full max-w-md rounded-3xl shadow-2xl p-8 lg:p-10 animate-fade-in-up">

                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center gap-3 mb-8">
                    <div class="w-11 h-11 rounded-xl bg-white shadow-sm border border-slate-100 flex items-center justify-center p-1.5">
                        <img src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom" class="w-full">
                    </div>
                    <span class="text-slate-800 font-bold">Monitoring Proyek</span>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-800">Buat Akun Baru</h2>
                    <p class="text-slate-500 text-sm mt-2">Isi data di bawah untuk mendaftar</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- NAME -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="Masukkan nama lengkap"
                                class="input-field w-full pl-11 pr-4 py-3 rounded-xl bg-white text-sm text-slate-800 outline-none">
                        </div>
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wider">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="nama@telkom.co.id"
                                class="input-field w-full pl-11 pr-4 py-3 rounded-xl bg-white text-sm text-slate-800 outline-none">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- ROLE -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wider">Role</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                            <select name="role" required
                                class="select-field w-full pl-11 pr-10 py-3 rounded-xl bg-white text-sm text-slate-800 outline-none cursor-pointer">
                                <option value="" disabled selected class="text-slate-400">Pilih Role</option>
                                <option value="optima" {{ old('role') == 'optima' ? 'selected' : '' }} class="text-slate-800">Optima</option>
                                <option value="tif" {{ old('role') == 'tif' ? 'selected' : '' }} class="text-slate-800">TIF</option>
                                <option value="telkom_akses" {{ old('role') == 'telkom_akses' ? 'selected' : '' }} class="text-slate-800">Telkom Akses</option>
                            </select>
                        </div>
                        @error('role')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- PASSWORD -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <input type="password" name="password" required
                                placeholder="Minimal 8 karakter"
                                class="input-field w-full pl-11 pr-4 py-3 rounded-xl bg-white text-sm outline-none">
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wider">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" required
                                placeholder="Ulangi password"
                                class="input-field w-full pl-11 pr-4 py-3 rounded-xl bg-white text-sm outline-none">
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <div class="pt-2">
                        <button type="submit"
                            class="btn-primary w-full py-3.5 rounded-xl font-semibold text-white text-sm shadow-lg">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>

                <!-- LOGIN LINK -->
                <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-red-600 font-semibold hover:text-red-700 transition">
                            Masuk
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
