<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Monitoring Proyek</title>
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
    </style>
</head>

<body class="min-h-screen bg-slate-900 overflow-hidden">

    <!-- BACKGROUND PATTERN -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-red-950"></div>
        <!-- Decorative shapes -->
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-red-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 w-[300px] h-[300px] bg-red-700/5 rounded-full blur-2xl animate-float"></div>
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
                    Sistem 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-red-600">Monitoring</span>
                </h1>
                <p class="text-slate-400 text-base leading-relaxed">
                    Platform terpusat untuk memantau progres deployment, pengelolaan data order, dan pelaporan yang akurat bagi Unit Optima.
                </p>
                <!-- Stats -->
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

            <!-- Bottom: Footer -->
            <div class="animate-fade-in-up-delay-2 text-xs text-slate-600">
                &copy; {{ date('Y') }} PT Telkom Indonesia Tbk. All rights reserved.
            </div>
        </div>

        <!-- RIGHT PANEL: Login Form -->
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
                    <h2 class="text-2xl font-bold text-slate-800">Selamat Datang</h2>
                    <p class="text-slate-500 text-sm mt-2">Silakan login untuk mengakses dashboard</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input type="email" name="email" required autofocus
                                placeholder="nama@telkom.co.id"
                                class="input-field w-full pl-11 pr-4 py-3.5 rounded-xl bg-white text-sm outline-none">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <input type="password" name="password" required
                                placeholder="••••••••"
                                class="input-field w-full pl-11 pr-4 py-3.5 rounded-xl bg-white text-sm outline-none">
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- REMEMBER -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500 focus:ring-offset-0">
                            <span class="text-sm text-slate-500 group-hover:text-slate-700 transition">Ingat saya</span>
                        </label>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="btn-primary w-full py-3.5 rounded-xl font-semibold text-white text-sm shadow-lg">
                        Masuk
                    </button>
                </form>

                <!-- REGISTER LINK -->
                <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-red-600 font-semibold hover:text-red-700 transition">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
