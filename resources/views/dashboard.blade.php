<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .glass-dark {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

    </style>
</head>

<body class="relative min-h-screen overflow-x-hidden bg-slate-900">

    
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/background.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
    </div>

    
    <div class="absolute top-0 right-0 p-6 z-50 flex items-center gap-4">
        <div class="text-right hidden md:block">
            <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
            <p class="text-slate-300 text-xs">{{ Auth::user()->email }}</p>
        </div>
        <div class="h-8 w-px bg-white/20 hidden md:block"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="glass-dark hover:bg-white/10 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 group">
                <span>Keluar</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>
    </div>

    
    <div class="relative z-10 min-h-screen w-full flex flex-col items-center justify-center p-6 mx-auto">
        
        
        <div class="text-center mb-12 mx-auto">
            <span class="inline-block py-1 px-3 rounded-full bg-red-600/20 border border-red-500/30 text-red-100 text-xs font-semibold tracking-wider uppercase mb-4 backdrop-blur-sm">
                Project Dashboard
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 tracking-tight">
                Selamat Datang di <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-white">Telkom Portal</span>
            </h1>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto">
                Platform manajemen deployment dan evaluasi kualitas jaringan.
            </p>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl mx-auto">
            
            
            <a href="#" class="group relative h-72 rounded-3xl p-1 overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-500/20">
                
                <div class="absolute inset-0 bg-gradient-to-br from-white/40 via-white/10 to-white/5 rounded-3xl z-0"></div>
                
                
                <div class="relative h-full bg-slate-900/40 backdrop-blur-xl rounded-[22px] p-8 flex flex-col justify-between border border-white/10 overflow-hidden group-hover:bg-slate-900/60 transition-colors">
                    
                    
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/20 rounded-full blur-3xl group-hover:bg-blue-500/30 transition-all"></div>
                    <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-purple-500/20 rounded-full blur-3xl group-hover:bg-purple-500/30 transition-all"></div>
                    


                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 mb-6 group-hover:scale-110 transition-transform duration-500 border border-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2 tracking-tight group-hover:text-blue-400 transition-colors">Quality Enhancement</h2>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xs">Evaluasi kualitas jaringan & performa teknisi lapangan dengan metrik terukur.</p>
                    </div>

                     <div class="relative z-10 flex justify-end items-end">
                        <span class="flex items-center gap-2 text-sm font-semibold text-slate-400 group-hover:text-white transition-colors">
                            
                            <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border border-white/5 group-hover:bg-blue-600 group-hover:border-blue-500 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </span>
                    </div>
                </div>
            </a>

            
            <a href="{{ route('deployment.b2b') }}" class="group relative h-72 rounded-3xl p-1 overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-red-500/20">
                
                 <div class="absolute inset-0 bg-gradient-to-br from-white/40 via-white/10 to-white/5 rounded-3xl z-0"></div>

                
                <div class="relative h-full bg-slate-900/40 backdrop-blur-xl rounded-[22px] p-8 flex flex-col justify-between border border-white/10 overflow-hidden group-hover:bg-slate-900/60 transition-colors">
                    
                     
                     <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-500/20 rounded-full blur-3xl group-hover:bg-red-500/30 transition-all"></div>
                     <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-orange-500/20 rounded-full blur-3xl group-hover:bg-orange-500/30 transition-all"></div>
                     


                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/30 mb-6 group-hover:scale-110 transition-transform duration-500 border border-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2 tracking-tight group-hover:text-red-400 transition-colors">Deployment System</h2>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xs">Monitoring & manajemen proyek B2B secara real-time dengan data akurat.</p>
                    </div>

                    <div class="relative z-10 flex justify-end items-end">
                        <span class="flex items-center gap-2 text-sm font-semibold text-slate-400 group-hover:text-white transition-colors">
                            
                            <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border border-white/5 group-hover:bg-red-600 group-hover:border-red-500 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </span>
                    </div>
                </div>
            </a>

        </div>

    </div>

    
    <div class="absolute bottom-6 left-0 w-full text-center z-10">
        <p class="text-slate-400 text-xs tracking-wide opacity-80">
            &copy; {{ date('Y') }} PT. Telkom Indonesia (Persero) Tbk. All rights reserved.
        </p>
    </div>


</body>
</html>
