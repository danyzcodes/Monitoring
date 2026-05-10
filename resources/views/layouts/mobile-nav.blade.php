<nav x-data="{ showMenu: false }" class="block lg:hidden">
    {{-- OVERLAY BACKDROP --}}
    <div x-show="showMenu"
         @click="showMenu = false"
         x-transition.opacity.duration.300ms
         class="fixed inset-0 z-40 bg-slate-900/20 backdrop-blur-sm"
         style="display: none;">
    </div>

    {{-- FLOATING SHELF MENU (Rak) --}}
    <div x-cloak x-show="showMenu"
         @click.outside="showMenu = false"
         x-transition:enter="transition ease-out duration-300 origin-bottom-right"
         x-transition:enter-start="opacity-0 translate-y-8 scale-75"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 origin-bottom-right"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 scale-75"
         class="fixed z-50 w-72 right-4 bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-slate-100/80 p-4"
         style="bottom: calc(5rem + env(safe-area-inset-bottom, 0px)); display: none;">
        
        <div class="flex items-center justify-between mb-3 px-1">
            <h3 class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Menu Pintas</h3>
            <button @click="showMenu = false" class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        {{-- Grid Layout Inside Shelf (3 Columns) --}}
        <div class="grid grid-cols-3 gap-y-6 gap-x-2 pb-2 pt-4 px-1">
            
            {{-- OLO (All) --}}
            <a href="{{ route('deployment.olo') }}" class="flex flex-col items-center gap-2 group transition active:scale-95">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 flex items-center justify-center text-orange-600 shadow-sm border border-orange-200/50 group-hover:bg-gradient-to-br group-hover:from-orange-100 group-hover:to-orange-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 008.716-6.747M12 21a9 9 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                </div>
                <span class="text-[9px] font-bold text-slate-600 text-center leading-tight">Dashboard<br>OLO</span>
            </a>

            {{-- Upload Data (All) --}}
            <a href="{{ route('deployment.upload') }}" class="flex flex-col items-center gap-2 group transition active:scale-95">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center text-purple-600 shadow-sm border border-purple-200/50 group-hover:bg-gradient-to-br group-hover:from-purple-100 group-hover:to-purple-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                </div>
                <span class="text-[9px] font-bold text-slate-600 text-center leading-tight">Upload<br>Data</span>
            </a>

            @if(auth()->user()->role === 'admin')
            {{-- Kelola Akun (Admin) --}}
            <a href="{{ route('admin.users') }}" class="flex flex-col items-center gap-2 group transition active:scale-95">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center text-blue-600 shadow-sm border border-blue-200/50 group-hover:bg-gradient-to-br group-hover:from-blue-100 group-hover:to-blue-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                </div>
                <span class="text-[9px] font-bold text-slate-600 text-center leading-tight">Kelola<br>Akun</span>
            </a>

            {{-- Master Input (Admin) --}}
            <a href="{{ route('admin.master-input') }}" class="flex flex-col items-center gap-2 group transition active:scale-95">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-200/50 group-hover:bg-gradient-to-br group-hover:from-emerald-100 group-hover:to-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" /></svg>
                </div>
                <span class="text-[9px] font-bold text-slate-600 text-center leading-tight">Master<br>Input</span>
            </a>

            {{-- Progress Overview (Admin) --}}
            <a href="{{ route('deployment.progress-overview') }}" class="flex flex-col items-center gap-2 group transition active:scale-95">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 flex items-center justify-center text-orange-600 shadow-sm border border-orange-200/50 group-hover:bg-gradient-to-br group-hover:from-orange-100 group-hover:to-orange-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
                <span class="text-[9px] font-bold text-slate-600 text-center leading-tight">Progress<br>Overview</span>
            </a>
            @endif
            
            {{-- Profile --}}
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-2 group transition active:scale-95">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-600 shadow-sm border border-slate-300/50 group-hover:bg-gradient-to-br group-hover:from-slate-200 group-hover:to-slate-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                </div>
                <span class="text-[9px] font-bold text-slate-600 text-center leading-tight">Profil<br>Pengguna</span>
            </a>
        </div>
    </div>

    {{-- FIXED BOTTOM NAV BAR --}}
    <div class="fixed bottom-0 left-0 z-40 w-full bg-white/95 backdrop-blur-md"
         style="padding-bottom: env(safe-area-inset-bottom); border-top: 1px solid rgba(148,163,184,0.15); border-radius: 20px 20px 0 0; box-shadow: 0 -8px 32px rgba(0,0,0,0.08);">
         
        <div class="h-16 max-w-md mx-auto flex items-center justify-around px-2">
            
            {{-- 1. Update --}}
            @php $isUpdate = request()->routeIs('deployment.update') || request()->routeIs('deployment.edit'); @endphp
            <a href="{{ route('deployment.update') }}" 
            class="relative flex flex-col items-center justify-center w-full h-full gap-1 pt-1 {{ $isUpdate ? 'text-red-600' : 'text-slate-400 hover:text-slate-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="{{ $isUpdate ? '2.5' : '2' }}" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                @if(isset($overdueCount) && $overdueCount > 0 && auth()->user()->role !== 'admin')
                    <span class="absolute top-1 right-2 w-2.5 h-2.5 bg-yellow-400 border-[1.5px] border-white rounded-full"></span>
                @endif
                <span class="text-[10px] font-bold tracking-wide">Update</span>
            </a>

            {{-- 2. Lihat Data --}}
            @php $isLihat = request()->routeIs('deployment.lihat-data'); @endphp
            <a href="{{ route('deployment.lihat-data') }}" 
            class="flex flex-col items-center justify-center w-full h-full gap-1 pt-1 {{ $isLihat ? 'text-red-600' : 'text-slate-400 hover:text-slate-600' }}">
                <svg class="w-6 h-6" fill="{{ $isLihat ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ $isLihat ? '0' : '2' }}" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-[10px] font-bold tracking-wide">Lihat</span>
            </a>

            {{-- 3. Input (Center / Important) --}}
            @php $isInput = request()->routeIs('deployment.input'); @endphp
            <a href="{{ route('deployment.input') }}" class="relative flex flex-col items-center justify-center -mt-6">
                <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-transform active:scale-95 border-4 border-slate-100 {{ $isInput ? 'bg-slate-800 shadow-slate-800/30 text-white' : 'bg-red-600 shadow-red-600/30 text-white' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-[10px] font-bold tracking-wide mt-1 {{ $isInput ? 'text-slate-800' : 'text-slate-500' }}">Input</span>
            </a>
            
            {{-- 4. Overview OR Dashboard (Role Based) --}}
            @if(auth()->user()->role === 'admin')
                @php $isDash = request()->routeIs('admin.dashboard'); @endphp
                <a href="{{ route('admin.dashboard') }}" 
                class="flex flex-col items-center justify-center w-full h-full gap-1 pt-1 {{ $isDash ? 'text-red-600' : 'text-slate-400 hover:text-slate-600' }}">
                    <svg class="w-6 h-6" fill="{{ $isDash ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ $isDash ? '0' : '2' }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4.5 10.5V21h15V10.5" />
                    </svg>
                    <span class="text-[10px] font-bold tracking-wide">Dashboard</span>
                </a>
            @else
                @php $isOverview = request()->routeIs('deployment.progress-overview'); @endphp
                <a href="{{ route('deployment.progress-overview') }}" 
                class="flex flex-col items-center justify-center w-full h-full gap-1 pt-1 {{ $isOverview ? 'text-red-600' : 'text-slate-400 hover:text-slate-600' }}">
                    <svg class="w-6 h-6" fill="{{ $isOverview ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ $isOverview ? '0' : '2' }}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="text-[10px] font-bold tracking-wide">Overview</span>
                </a>
            @endif

            {{-- 5. More Menu --}}
            <button @click="showMenu = true" 
               class="flex flex-col items-center justify-center w-full h-full gap-1 pt-1 text-slate-400 hover:text-slate-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="text-[10px] font-bold tracking-wide">Lainnya</span>
            </button>

        </div>
    </div>
</nav>
