<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Monitoring Proyek</title>

    <!-- Nonaktifkan prefetch otomatis Turbo (penyebab bounce-back bug) -->
    <meta name="turbo-prefetch" content="false">
    <!-- Turbo: jangan cache halaman agar redirect tidak menyebabkan bounce-back -->
    <meta name="turbo-cache-control" content="no-cache">


    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important
        }

        /* YouTube-style Turbo Progress Bar */
        .turbo-progress-bar {
            height: 3px;
            background-color: #ef4444; /* red-500 */
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
            z-index: 9999;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased overflow-y-scroll">

    <div x-data="{
        sidebarOpen: true, // Desktop sidebar state
        userMenu: false,
    }" class="min-h-screen relative">

        <!-- ================= SIDEBAR (DESKTOP ONLY) ================= -->
        <aside id="sidebar"
            class="hidden lg:flex fixed inset-y-0 left-0 z-50
               bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800
               border-r border-slate-700/50
               transition-all duration-300 ease-in-out
               flex-col overflow-hidden shadow-none"
            :style="sidebarOpen ? 'width:260px' : 'width:72px'">

            <!-- LOGO AREA -->
            <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-700/50 shrink-0 relative">
                {{-- Telkom Logo --}}
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

            <!-- MENU LABEL (Admin Only) -->
            @if (auth()->user()->role === 'admin')
                <div class="px-5 pt-5 pb-2" x-show="sidebarOpen" x-transition.opacity>
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-slate-500"></span>
                </div>
            @endif

            <!-- MENU ITEMS -->
            <nav class="flex-1 px-3 space-y-1 text-sm overflow-y-auto overflow-x-hidden pt-4 lg:pt-0">

                @if (auth()->user()->role === 'admin')
                    {{-- ADMIN DASHBOARD --}}
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
                    {{-- AKUN --}}
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

                    {{-- MASTER INPUT --}}
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

                {{-- B2B DEPLOYMENT (Submenu) --}}
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

                        <!-- ICON -->
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

                        <!-- ARROW -->
                        <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>

                    </button>

                    <!-- SUBMENU -->
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

        <!-- ================= NAVBAR ================= -->
        <header id="top-navbar"
            class="fixed top-0 right-0 z-30 h-16
               bg-white border-b border-slate-200
               flex items-center justify-between px-6 transition-all duration-300"
            :style="sidebarOpen ? 'left:260px' : 'left:72px'">

            {{-- Mobile: Left 0 override handled by specific class if needed, but since sidebar is hidden on mobile, left:0 is fine --}}
            <style>
                @media (max-width: 1024px) {
                    #top-navbar {
                        left: 0 !important;
                    }

                    #main-content {
                        margin-left: 0 !important;
                    }
                }
            </style>

            <!-- LEFT: Toggle + Page Title -->
            <div class="flex items-center gap-4">
                {{-- Toggle Button: Hidden on Mobile --}}
                <button @click="sidebarOpen = !sidebarOpen"
                    class="hidden lg:block p-2 rounded-lg hover:bg-slate-100 transition text-slate-500 hover:text-slate-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Project Title: Visible Everywhere --}}
                <div class="flex items-center gap-2">
                    {{-- Mobile Logo --}}
                    <div class="lg:hidden w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>

                </div>
            </div>

            <!-- RIGHT: User Dropdown -->
            <div class="flex items-center gap-3">

                {{-- Notification Bell --}}
                @if (auth()->user()->role !== 'admin')
                    <a href="{{ route('notifications.index') }}"
                        class="relative p-2 rounded-lg hover:bg-slate-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        @if (isset($overdueCount) && $overdueCount > 0)
                            <span
                                class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-red-500 rounded-full">
                                {{ $overdueCount }}
                            </span>
                        @endif
                    </a>
                @endif

                {{-- Role Badge --}}
                <span
                    class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold uppercase tracking-wide
                    {{ auth()->user()->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ auth()->user()->role }}
                </span>

                {{-- User Dropdown --}}
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

                    <!-- Dropdown Panel -->
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

                        {{-- User Info Header --}}
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

                        {{-- Menu Items --}}
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

                        {{-- Logout --}}
                        <div class="border-t border-slate-100">
                            <form method="POST" action="{{ route('logout') }}">
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

        <!-- ================= MAIN ================= -->
        <main id="main-content" class="pt-20 transition-all duration-300 min-h-screen"
            :style="sidebarOpen ? 'margin-left:260px' : 'margin-left:72px'">
            <div style="padding: 1rem; padding-bottom: 6rem;">
                @yield('content')
                @include('components.flash-success')
                @include('components.flash-error')
            </div>
        </main>

        {{-- MOBILE NAVIGATION --}}
        @include('layouts.mobile-nav')

    </div>

    @stack('scripts')

    {{-- Turbo Drive: re-init Alpine.js on each Turbo navigation --}}
    <script>
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

        // Fix: setelah form submit dengan Turbo, force full reload jika ada redirect
        document.addEventListener('turbo:visit', function(event) {
            const url = event.detail.url;
            // Jika navigasi ke halaman yang sama (tanda bounce-back), force reload
            if (url === window.location.href) {
                event.preventDefault();
                window.location.reload();
            }
        });
    </script>

</body>

</html>
