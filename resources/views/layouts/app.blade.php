<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Dashboard') </title>


    <link rel="icon" href="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" type="image/png">

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tom Select -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important
        }

        .turbo-progress-bar {
            height: 3px;
            background-color: #ef4444; 
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
            z-index: 9999;
        }

        /* Force sidebar display on desktop to prevent Tailwind hidden conflict */
        @media (min-width: 1024px) {
            #sidebar {
                display: flex !important;
            }
        }

        /* ====== MOBILE FIXES ====== */
        /* Override Alpine inline margin-left on mobile — inline style wins over class,
           so we need !important here */
        @media (max-width: 1023px) {
            #main-content {
                margin-left: 0 !important;
            }
            #top-navbar {
                left: 0 !important;
                /* Safe area for Android notch */
                padding-left: max(1.5rem, env(safe-area-inset-left));
                padding-right: max(1.5rem, env(safe-area-inset-right));
            }
        }

        /* Prevent content being hidden behind mobile bottom nav (~80px) */
        @media (max-width: 1023px) {
            #main-content {
                padding-bottom: calc(5.5rem + env(safe-area-inset-bottom, 0px)) !important;
            }
        }

        /* Safe area for top navbar on all screens */
        @supports (padding-top: env(safe-area-inset-top)) {
            #top-navbar {
                padding-top: env(safe-area-inset-top);
                height: calc(4rem + env(safe-area-inset-top));
            }
            #main-content {
                padding-top: calc(5rem + env(safe-area-inset-top));
            }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased overflow-y-scroll">

    <div x-data="{
        sidebarOpen: true, // Desktop sidebar state
        userMenu: false,
    }" class="min-h-screen relative">

        
        <aside id="sidebar"
            class="hidden lg:flex fixed inset-y-0 left-0 z-50
               bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800
               border-r border-slate-700/50
               transition-all duration-300 ease-in-out
               flex-col overflow-hidden shadow-none"
            :style="sidebarOpen ? 'width:260px' : 'width:72px'">

            
            <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-700/50 shrink-0 relative">
                
                <div class="w-9 h-9 rounded-lg bg-white flex items-center justify-center shrink-0 p-1 opacity-95 hover:opacity-100 transition-opacity">
                    <img src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom Logo" class="w-full">
                </div>

                <div x-show="sidebarOpen" x-transition.opacity.duration.200ms
                    class="leading-tight overflow-hidden whitespace-nowrap">
                    <div class="font-bold text-sm text-white tracking-wide">
                        Monitoring Proyek
                    </div>
                    <div class="text-[11px] text-slate-400">
                        Unit Optima · PT Telkom
                    </div>
                </div>
            </div>

            
            @if (auth()->user()->role === 'admin')
                <div class="px-5 pt-5 pb-2" x-show="sidebarOpen" x-transition.opacity>
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-slate-500"></span>
                </div>
            @endif

            
            <nav class="flex-1 px-3 space-y-1 text-sm overflow-y-auto overflow-x-hidden pt-4 lg:pt-0">

                @if (auth()->user()->role === 'admin')
                    
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ request()->routeIs('admin.dashboard')
                        ? 'bg-red-600/20 text-red-400 border-l-[3px] border-red-500'
                        : 'text-slate-300 hover:bg-slate-700/50 hover:text-white border-l-[3px] border-transparent' }}"
                        :class="!sidebarOpen ? 'justify-center px-0 !border-l-0' : ''">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l9-9 9 9M4.5 10.5V21h15V10.5" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Dashboard</span>
                    </a>
                @endif

                @if (auth()->user()->role === 'admin')
                    
                    <a href="{{ route('admin.users') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ request()->routeIs('admin.users')
                        ? 'bg-red-600/20 text-red-400 border-l-[3px] border-red-500'
                        : 'text-slate-300 hover:bg-slate-700/50 hover:text-white border-l-[3px] border-transparent' }}"
                        :class="!sidebarOpen ? 'justify-center px-0 !border-l-0' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Kelola Akun</span>
                    </a>

                    
                    <a href="{{ route('admin.master-input') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                    {{ request()->routeIs('admin.master-input')
                        ? 'bg-red-600/20 text-red-400 border-l-[3px] border-red-500'
                        : 'text-slate-300 hover:bg-slate-700/50 hover:text-white border-l-[3px] border-transparent' }}"
                        :class="!sidebarOpen ? 'justify-center px-0 !border-l-0' : ''">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Master Input</span>
                    </a>
                @endif

                
                <div x-data="{
                    open: {{ request()->routeIs('deployment.*') && !request()->routeIs('deployment.olo') ? 'true' : 'false' }},
                    init() {
                        this.$watch('$root.sidebarOpen', v => {
                            if (!v) this.open = false
                        })
                    }
                }" class="pt-1">

                    <button @click="open = !open; if(!sidebarOpen) sidebarOpen = true"
                        class="flex items-center w-full
                                py-2.5 rounded-xl transition-all duration-200
                            {{ request()->routeIs('deployment.*') && !request()->routeIs('deployment.olo')
                                ? 'bg-red-600/20 text-red-400 border-l-[3px] border-red-500'
                                : 'text-slate-300 hover:bg-slate-700/50 hover:text-white border-l-[3px] border-transparent' }}"
                        :class="sidebarOpen
                            ?
                            'justify-between px-3' :
                            'justify-center px-0 border-l-0'">

                        
                        <div class="flex items-center" :class="sidebarOpen ? 'gap-3' : 'gap-0'">

                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 7a2 2 0 012-2h5l2 2h7a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                            </svg>

                            <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">
                                B2B Deployment
                            </span>
                        </div>

                        
                        <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>

                    </button>

                    
                    <div x-cloak x-show="open && sidebarOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="ml-5 mt-1 pl-4 space-y-0.5 border-l border-slate-700">

                        @php
                            $a = 'bg-red-600/10 text-red-400 font-medium';
                            $n = 'text-slate-400 hover:text-white hover:bg-slate-700/40';
                        @endphp

                        <a href="{{ route('deployment.upload') }}"
                            class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('deployment.upload') ? $a : $n }}">
                            Upload Data
                        </a>

                        <a href="{{ route('deployment.input') }}"
                            class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('deployment.input') ? $a : $n }}">
                            Input Data
                        </a>

                        <a href="{{ route('deployment.update') }}"
                            class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('deployment.update') ? $a : $n }}">
                            <span>Update Data</span>
                            @if (auth()->user()->role === 'optima' && isset($overdueCount) && $overdueCount > 0)
                                <span
                                    class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold text-white bg-red-500 rounded-full animate-pulse">
                                    {{ $overdueCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('deployment.lihat-data') }}"
                            class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('deployment.lihat-data') ? $a : $n }}">
                            Lihat Data
                        </a>

                        <a href="{{ route('deployment.progress-overview') }}"
                            class="block px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('deployment.progress-overview') ? $a : $n }}">
                            Progress Overview
                        </a>
                    </div>
                </div>

            </nav>

        </aside>

        
        <header id="top-navbar"
            class="fixed top-0 right-0 z-30 h-16
               bg-white border-b border-slate-200
               flex items-center justify-between px-6 transition-all duration-300"
            :style="sidebarOpen ? 'left:260px' : 'left:72px'">

            



            
            <div class="flex items-center gap-4">
                
                <button @click="sidebarOpen = !sidebarOpen"
                    class="hidden lg:block p-2 rounded-lg hover:bg-slate-100 transition text-slate-500 hover:text-slate-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                
                <div class="flex items-center gap-2">
                    
                    <div class="lg:hidden w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0 p-1 opacity-95">
                        <img src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom Logo" class="w-full">
                    </div>

                </div>
            </div>

            
            <div class="flex items-center gap-3">

                
                @if (auth()->user()->role !== 'admin')
                    <div x-data="{ notifOpen: false }" class="relative">

                        
                        <button @click="notifOpen = !notifOpen"
                            id="notif-bell-btn"
                            class="relative group p-2.5 rounded-xl transition-all duration-200
                                   hover:bg-red-50 hover:shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-red-200">
                            @if (isset($overdueCount) && $overdueCount > 0)
                                
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-[18px] h-[18px] text-red-500 notif-bell-shake"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                                
                                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white
                                             animate-ping opacity-75"></span>
                                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-[18px] h-[18px] text-slate-400 group-hover:text-slate-600 transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                            @endif
                        </button>

                        
                        <div x-show="notifOpen"
                            @click.outside="notifOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            x-cloak
                            class="absolute right-0 mt-3 w-[360px] z-50
                                   rounded-2xl overflow-hidden
                                   border border-slate-200/80
                                   shadow-[0_8px_30px_rgba(0,0,0,0.12)]
                                   bg-white">

                            
                            <div class="absolute -top-2 right-3.5 w-4 h-4 bg-white border-l border-t border-slate-200/80
                                        rotate-45 rounded-tl-sm z-10"></div>

                            
                            <div class="relative px-4 pt-4 pb-3 bg-gradient-to-br from-red-500 to-rose-600 overflow-hidden">
                                
                                <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-white/10"></div>
                                <div class="absolute -bottom-6 -left-4 w-24 h-24 rounded-full bg-white/5"></div>

                                <div class="relative flex items-center justify-between">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                            </svg>
                                            <h3 class="text-sm font-bold text-white tracking-wide">Notifikasi</h3>
                                        </div>
                                        @if (isset($overdueCount) && $overdueCount > 0)
                                            <p class="text-[11px] text-white/70 mt-0.5">
                                                {{ $overdueCount }} order melewati tanggal komitmen
                                            </p>
                                        @else
                                            <p class="text-[11px] text-white/70 mt-0.5">Semua order dalam kondisi baik</p>
                                        @endif
                                    </div>
                                    @if (isset($overdueCount) && $overdueCount > 0)
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm">
                                            <span class="text-lg font-black text-white leading-none">{{ $overdueCount }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="max-h-[320px] overflow-y-auto">
                                @if (isset($overdueOrders) && $overdueOrders->count() > 0)
                                    <div class="p-3 space-y-2">
                                        @foreach ($overdueOrders->take(5) as $notifOrder)
                                            @php
                                                $daysOverdue = (int) floor(\Carbon\Carbon::parse($notifOrder->data['commitment_date'])->diffInDays(\Carbon\Carbon::now()));
                                                $urgencyClass = $daysOverdue >= 7
                                                    ? 'border-red-300 bg-red-50'
                                                    : ($daysOverdue >= 3
                                                        ? 'border-orange-200 bg-orange-50'
                                                        : 'border-yellow-200 bg-yellow-50');
                                                $dotClass = $daysOverdue >= 7
                                                    ? 'bg-red-500'
                                                    : ($daysOverdue >= 3
                                                        ? 'bg-orange-400'
                                                        : 'bg-yellow-400');
                                                $badgeClass = $daysOverdue >= 7
                                                    ? 'bg-red-100 text-red-700'
                                                    : ($daysOverdue >= 3
                                                        ? 'bg-orange-100 text-orange-700'
                                                        : 'bg-yellow-100 text-yellow-700');
                                            @endphp
                                            <div class="rounded-xl border {{ $urgencyClass }} p-3 transition-all duration-150 hover:shadow-sm group/card">
                                                <div class="flex items-start gap-2.5">
                                                    
                                                    <div class="mt-1.5 w-2 h-2 rounded-full {{ $dotClass }} shrink-0 ring-2 ring-white shadow-sm"></div>

                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-start justify-between gap-2">
                                                            <div class="min-w-0">
                                                                <p class="text-[11px] font-bold text-slate-800 truncate leading-tight">
                                                                    {{ $notifOrder->star_click_id }}
                                                                </p>
                                                                <p class="text-[10px] text-slate-500 truncate mt-0.5">
                                                                    {{ $notifOrder->nama_customer }}
                                                                </p>
                                                            </div>
                                                            <span class="shrink-0 text-[10px] font-semibold px-1.5 py-0.5 rounded-md {{ $badgeClass }}">
                                                                {{ $daysOverdue }} hr lalu
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center justify-between mt-2">
                                                            <div class="flex items-center gap-1.5 text-[10px] text-slate-400">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                                                </svg>
                                                                {{ \Carbon\Carbon::parse($notifOrder->data['commitment_date'])->format('d M Y') }}
                                                                <span class="text-slate-300">·</span>
                                                                {{ $notifOrder->datel ?? '-' }}
                                                            </div>
                                                            <a href="{{ route('deployment.edit', $notifOrder->id) }}"
                                                                class="inline-flex items-center gap-1 text-[10px] font-semibold text-white
                                                                       bg-slate-700 hover:bg-slate-900 rounded-lg px-2 py-1 transition-all duration-150
                                                                       opacity-0 group-hover/card:opacity-100 translate-x-1 group-hover/card:translate-x-0">
                                                                Update
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                @else
                                    
                                    <div class="flex flex-col items-center justify-center py-10 px-4 text-center">
                                        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mb-3 shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-700 flex items-center justify-center gap-1.5">
                                            Semua beres!
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                            </svg>
                                        </p>
                                        <p class="text-[11px] text-slate-400 mt-1 max-w-[200px] leading-relaxed">
                                            Tidak ada order yang melewati tanggal komitmen
                                        </p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                    
                    <style>
                        @keyframes bell-shake {
                            0%, 100% { transform: rotate(0deg); }
                            15%       { transform: rotate(10deg); }
                            30%       { transform: rotate(-8deg); }
                            45%       { transform: rotate(6deg); }
                            60%       { transform: rotate(-4deg); }
                            75%       { transform: rotate(2deg); }
                        }
                        .notif-bell-shake {
                            animation: bell-shake 2.5s ease-in-out infinite;
                            transform-origin: top center;
                        }
                    </style>
                @endif

                
                <span
                    class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold uppercase tracking-wide
                    {{ auth()->user()->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ auth()->user()->role }}
                </span>

                
                <div x-data="{ userMenu: false }" class="relative">
                    <button @click="userMenu = !userMenu"
                        class="flex items-center gap-2 pl-3 pr-1 py-1 rounded-full
                               hover:bg-slate-100 transition focus:outline-none">
                        <span
                            class="text-sm font-medium text-slate-700 hidden sm:block">{{ auth()->user()->name }}</span>
                        <div
                            class="w-9 h-9 rounded-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </button>

                    
                    <div x-show="userMenu" @click.outside="userMenu = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        x-cloak
                        class="absolute right-0 mt-2 w-64
                               bg-white border border-slate-200
                               rounded-2xl shadow-xl overflow-hidden z-50">

                        
                        <div class="px-4 py-4 bg-slate-50 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-11 h-11 rounded-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="py-2">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Profile Saya
                            </a>

                        </div>

                        
                        <div class="border-t border-slate-100">
                            <form method="POST" action="{{ route('logout') }}" data-turbo="false">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </header>

        
        <main id="main-content" class="pt-20 transition-all duration-300 min-h-screen"
            :style="sidebarOpen ? 'margin-left:260px' : 'margin-left:72px'">
            <div style="padding: 1rem; padding-bottom: 6rem;">
                @yield('content')
                @include('components.flash-success')
                @include('components.flash-error')
            </div>
        </main>

        
        @include('layouts.mobile-nav')

    </div>

    @stack('scripts')

    
    <script>
        if (!window.appScriptInitialized) {
            // Fix bounce-back: matikan Turbo cache sepenuhnya
            document.addEventListener('turbo:before-cache', function() {
                // Hapus semua Alpine state sebelum Turbo cache page
                document.querySelectorAll('[x-data]').forEach(function(el) {
                    if (el._x_dataStack) {
                        try { window.Alpine.destroyTree(el); } catch (e) {}
                    }
                });
                // Tandai semua halaman sebagai no-cache
                const meta = document.querySelector('meta[name="turbo-cache-control"]');
                if (!meta) {
                    const m = document.createElement('meta');
                    m.name = 'turbo-cache-control';
                    m.content = 'no-cache';
                    document.head.appendChild(m);
                }
            });

            // Re-init Alpine.js setelah Turbo navigasi
            document.addEventListener('turbo:load', function() {
                if (window.Alpine) {
                    document.querySelectorAll('[x-data]').forEach(function(el) {
                        if (!el._x_dataStack) {
                            window.Alpine.initTree(el);
                        }
                    });
                }
            });

            // Simpan posisi scroll sebelum submit atau navigasi
            window.lastScrollYPosition = 0;
            window.isSamePageFormSubmit = false;

            document.addEventListener('submit', function() {
                window.lastScrollYPosition = window.scrollY;
                window.isSamePageFormSubmit = true;
            });

            // Pertahankan posisi scroll jika setelah form submit kembali ke halaman yang sama
            document.addEventListener('turbo:render', function() {
                if (window.isSamePageFormSubmit) {
                    window.scrollTo(0, window.lastScrollYPosition);
                    window.isSamePageFormSubmit = false;
                }
            });

            // Clear any stale Service Workers from other projects running on the same port (e.g. 127.0.0.1:8000)
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.getRegistrations().then(function(registrations) {
                    let unregisteredAny = false;
                    let promises = registrations.map(function(reg) {
                        return reg.unregister().then(function(success) {
                            if (success) unregisteredAny = true;
                        });
                    });
                    Promise.all(promises).then(function() {
                        if (unregisteredAny) {
                            console.log('Stale Service Worker cleared. Reloading page...');
                            window.location.reload();
                        }
                    });
                }).catch(function(err) {
                    console.warn('Error clearing service workers:', err);
                });
            }

            window.appScriptInitialized = true;
        }
    </script>

</body>

</html>
