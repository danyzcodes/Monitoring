@if (session('success'))
@php
    $flash_id = uniqid();
@endphp
<div x-data="{ show: !sessionStorage.getItem('flash_{{ $flash_id }}') }"
     x-show="show"
     x-init="if (show) { sessionStorage.setItem('flash_{{ $flash_id }}', 'true'); setTimeout(() => show = false, 3000); }"
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
         class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center border border-white/20">

        
        <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        
        <h3 class="text-xl font-bold text-slate-800 mb-2">Berhasil!</h3>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">
            {{ session('success') }}
        </p>

        
        <button @click="show = false" 
                class="w-full py-3 px-4 bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl transition transform hover:-translate-y-0.5 shadow-lg shadow-red-600/30">
            OK, Mengerti
        </button>
    </div>
</div>
@endif
