@extends('layouts.app')

@section('title', 'B2B Deployment')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        
        <a href="{{ route('deployment.input') }}"
           class="group relative overflow-hidden rounded-3xl p-8 h-64
                  bg-gradient-to-br from-red-600 via-red-500 to-red-700
                  text-white shadow-xl hover:shadow-2xl hover:-translate-y-1
                  transition-all duration-300 flex flex-col justify-between">
            
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-black/10 rounded-full blur-xl -ml-10 -mb-5"></div>

            <div class="w-14 h-14 flex items-center justify-center
                        rounded-2xl bg-white/20 backdrop-blur-sm shadow-inner
                        group-hover:scale-110 transition z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>

            <div class="z-10">
                <h3 class="text-2xl font-bold">Input Data</h3>
                <p class="text-red-100 mt-1 text-sm font-medium opacity-90">
                    Tambah data deployment baru secara manual
                </p>
            </div>

            <div class="absolute top-6 right-6 px-3 py-1 rounded-full bg-white/20 text-xs font-bold backdrop-blur-md">
                Utama
            </div>
        </a>

        
        <a href="{{ route('deployment.update') }}"
           class="group relative overflow-hidden rounded-3xl p-8 h-64
                  bg-white border border-slate-200
                  hover:border-red-200 hover:shadow-xl hover:-translate-y-1
                  transition-all duration-300 flex flex-col justify-between">
            
            <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full blur-xl transition" style="background:#fef2f2;"></div>

            <div class="w-14 h-14 flex items-center justify-center
                        rounded-2xl group-hover:scale-110 transition z-10" style="background:#fef2f2; color:#e32b2b;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>

            <div class="z-10">
                <h3 class="text-xl font-bold text-slate-800 group-hover:text-red-600 transition">Update Progres</h3>
                <p class="text-slate-500 mt-1 text-sm">
                    Perbarui status progress deployment berjalan
                </p>
            </div>
        </a>

        
        <a href="{{ route('deployment.lihat-data') }}" 
           class="group relative overflow-hidden rounded-3xl p-8 h-64
                  bg-white border border-slate-200
                  hover:border-red-200 hover:shadow-xl hover:-translate-y-1
                  transition-all duration-300 flex flex-col justify-between">
            
            <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full blur-xl transition" style="background:#fef2f2;"></div>

            <div class="w-14 h-14 flex items-center justify-center
                        rounded-2xl group-hover:scale-110 transition z-10" style="background:#fef2f2; color:#e32b2b;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>

            <div class="z-10">
                <h3 class="text-xl font-bold text-slate-800 group-hover:text-red-600 transition">Lihat Data</h3>
                <p class="text-slate-500 mt-1 text-sm">
                    Monitoring dan rekap data deployment lengkap
                </p>
            </div>
        </a>

        
        <a href="{{ route('deployment.upload') }}"
           class="group relative overflow-hidden rounded-3xl p-8 h-64
                  bg-white border border-slate-200
                  hover:border-red-200 hover:shadow-xl hover:-translate-y-1
                  transition-all duration-300 flex flex-col justify-between">
            
            <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full blur-xl transition" style="background:#fef2f2;"></div>

            <div class="w-14 h-14 flex items-center justify-center
                        rounded-2xl group-hover:scale-110 transition z-10" style="background:#fef2f2; color:#e32b2b;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
            </div>

            <div class="z-10">
                <h3 class="text-xl font-bold text-slate-800 group-hover:text-red-600 transition">Upload Excel</h3>
                <p class="text-slate-500 mt-1 text-sm">
                    Import data massal via file excel
                </p>
            </div>
        </a>

        
        @if(in_array(auth()->user()->role, ['admin', 'optima']))
        <a href="{{ route('deployment.progress-overview') }}"
           class="group relative overflow-hidden rounded-3xl p-8 h-64
                  bg-white border border-slate-200
                  hover:border-red-200 hover:shadow-xl hover:-translate-y-1
                  transition-all duration-300 flex flex-col justify-between">
            
            <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full blur-xl transition" style="background:#fef2f2;"></div>

            <div class="w-14 h-14 flex items-center justify-center
                        rounded-2xl group-hover:scale-110 transition z-10" style="background:#fef2f2; color:#e32b2b;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>

            <div class="z-10">
                <h3 class="text-xl font-bold text-slate-800 group-hover:text-red-600 transition">Progress Overview</h3>
                <p class="text-slate-500 mt-1 text-sm">
                    Monitoring grafik dan statistik deployment
                </p>
            </div>
        </a>
        @endif

    </div>

</div>
@endsection

