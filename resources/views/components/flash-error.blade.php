@if (session('error'))
@php
    $flash_id = uniqid();
@endphp
<div x-data="{ show: !sessionStorage.getItem('flash_{{ $flash_id }}') }"
     x-show="show"
     x-init="if (show) { sessionStorage.setItem('flash_{{ $flash_id }}', 'true'); setTimeout(() => show = false, 5000); }"
     class="fixed inset-0 z-[999] flex items-center justify-center px-4"
     style="display: none;"
     data-turbo-cache="false"
     x-cloak>
    
    
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
         @click="show = false"></div>

    
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-90 translate-y-4"
         class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center border-2 border-red-500/20">

        
        <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-red-100 flex items-center justify-center animate-pulse">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>

        
        <h3 class="text-xl font-bold text-slate-800 mb-2">Terjadi Kesalahan</h3>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">
            {{ session('error') }}
        </p>

        
        <button @click="show = false" 
                class="w-full py-3 px-4 bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl transition transform hover:-translate-y-0.5 shadow-lg shadow-red-600/30">
            Tutup
        </button>
    </div>
</div>
@endif
