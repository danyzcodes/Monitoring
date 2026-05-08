@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')
<div class="max-w-6xl mx-auto" x-data="{ activeTab: 'info' }">

    {{-- PAGE HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Pengaturan Akun</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola informasi profil, keamanan, dan preferensi akun Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT COLUMN: Profile Card & Navigation --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- PROFILE CARD --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-br from-red-600 via-red-500 to-rose-500 h-28 relative">
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <path d="M0 50 Q 25 30 50 50 T 100 50 V 100 H 0 Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                        <div class="w-20 h-20 rounded-full bg-white shadow-lg flex items-center justify-center
                                    text-3xl font-bold text-red-600 border-4 border-white ring-2 ring-red-100">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
                <div class="pt-12 pb-5 px-5 text-center">
                    <h2 class="text-lg font-bold text-slate-800">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-slate-500 mt-0.5">{{ auth()->user()->email }}</p>
                    <div class="mt-3 flex items-center justify-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide
                            {{ auth()->user()->role === 'admin' ? 'bg-red-100 text-red-700 ring-1 ring-red-700/10' : 'bg-blue-100 text-blue-700 ring-1 ring-blue-700/10' }}">
                            {{ auth()->user()->role }}
                        </span>
                        @if(auth()->user()->email_verified_at)
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[11px] font-medium bg-green-100 text-green-700 ring-1 ring-green-700/10">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Terverifikasi
                            </span>
                        @endif
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 grid grid-cols-2 gap-2 text-center">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-medium">Bergabung</p>
                            <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ auth()->user()->created_at->format('d M Y') }}</p>
                        </div>
                        
                    </div>

                    {{-- Telegram Group Link --}}
                    <a href="https://t.me/+Wgw8a8geqfAyNTU1" target="_blank" rel="noopener noreferrer"
                        class="mt-4 flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-[#0088cc]/10 text-[#0088cc] text-sm font-semibold
                               hover:bg-[#0088cc]/20 transition-all duration-200 border border-[#0088cc]/20">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345.502.614.789 1.127 1.087 1.58a.504.504 0 0 1 .028.478c-.074.18-.353.548-.642.668-.31.13-.762.068-.99-.04-.275-.128-1.31-.863-2.309-1.593-.67-.49-1.216-.862-1.56-1.087-.39-.255-.86-.663-1.304-.663-.075 0-.171.019-.268.075a.5.5 0 0 0-.223.285c-.05.173-.077.494-.048.86.065.843.324 1.763.8 2.804.76 1.673 1.898 3.154 3.212 4.174 1.43 1.115 2.943 1.525 4.418 1.73.508.073.976.04 1.397-.073.67-.186 1.18-.604 1.53-1.073.04-.06.073-.12.1-.18.044-.09.086-.18.12-.28.084-.23.133-.47.154-.71.023-.27.014-.52-.014-.74a3.22 3.22 0 0 0-.073-.43c-.03-.1-.066-.21-.1-.32a12.655 12.655 0 0 0-.148-.49c-.05-.14-.1-.29-.143-.43-.09-.27-.17-.53-.23-.76-.1-.37-.16-.66-.16-.66s.04-.01.1-.01c.29.003.93.05 1.72.252 1.07.27 2.05.72 2.05.72s.68.28.93.4c.25.12.42.25.53.36.11.11.2.23.26.35.06.12.1.25.1.38 0 .13-.03.26-.09.39-.06.13-.14.25-.24.36-.1.11-.21.21-.33.3-.12.09-.25.17-.38.24-.13.07-.26.13-.4.18-.14.05-.28.09-.43.12-.15.03-.3.05-.45.05-.15 0-.3-.02-.45-.05a2.43 2.43 0 0 1-.43-.12c-.14-.05-.27-.11-.4-.18-.13-.07-.26-.15-.38-.24-.12-.09-.23-.19-.33-.3-.1-.11-.18-.23-.24-.36z"/>
                        </svg>
                        Gabung Grup Telegram
                    </a>
                </div>
            </div>

            {{-- UPDATE PASSWORD (Left Column) --}}
            <div x-ref="passwordSection" id="password" @scroll.into-view="activeTab = 'password'" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                @include('profile.partials.update-password-form')
            </div>

        </div>

        {{-- RIGHT COLUMN: Forms --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- UPDATE PROFILE INFO --}}
            <div x-ref="infoSection" @scroll.into-view="activeTab = 'info'" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- DELETE ACCOUNT --}}
            <div x-ref="deleteSection" @scroll.into-view="activeTab = 'delete'" class="bg-white rounded-2xl shadow-sm border border-red-200 p-6 lg:p-8">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>

</div>
@endsection
