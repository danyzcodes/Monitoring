<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan Admin</title>

    
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
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
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
    </style>
</head>

<body class="min-h-screen bg-slate-900 overflow-hidden flex items-center justify-center p-4" data-turbo="false">

    
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-red-950"></div>
        
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-red-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 w-[300px] h-[300px] bg-red-700/5 rounded-full blur-2xl animate-float"></div>
    </div>

    
    <div class="relative w-full max-w-md animate-fade-in-up">
        <div class="glass-card rounded-3xl shadow-2xl p-8 text-center border border-white/20">
            
            
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shadow-lg shadow-red-600/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            
            <h1 class="text-2xl font-bold text-slate-800 mb-2">
                Menunggu Persetujuan
            </h1>
            
            <div class="bg-red-50 rounded-xl p-4 mb-6 border border-red-100">
                <p class="text-sm text-red-800 font-medium">
                    "Halo {{ auth()->user()->name }}, akun Anda sedang dalam antrean verifikasi."
                </p>
            </div>

            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                Terima kasih telah mendaftar. Admin kami sedang meninjau permintaan Anda. 
                Silakan cek kembali secara berkala atau hubungi admin jika butuh bantuan segera.
            </p>

            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-primary w-full py-3.5 rounded-xl font-semibold text-white text-sm shadow-lg flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Kembali ke Login
                </button>
            </form>

            
            <div class="mt-8 pt-6 border-t border-slate-100">
                <p class="text-xs text-slate-400">
                    &copy; {{ date('Y') }} PT Telkom Indonesia Tbk.
                </p>
            </div>

        </div>
    </div>

</body>
</html>