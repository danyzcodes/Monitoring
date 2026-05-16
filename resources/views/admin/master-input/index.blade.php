@extends('layouts.app')

@section('title', 'Master Data Input')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

       <div class="flex items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('admin.dashboard') }}" class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
        <span class="text-slate-300 font-bold">❯</span>
        <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">master input</span>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition flex flex-col h-full">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-2 h-8 bg-blue-500 rounded-full"></span>
                    Datel
                </h3>
                <span class="text-xs font-semibold px-2 py-1 bg-slate-100 text-slate-600 rounded-lg">{{ $datels->count() }} Item</span>
            </div>
            
            <div class="p-6 flex-1 flex flex-col gap-6">
                
                <form method="POST" action="{{ route('admin.master-input.datel') }}" class="relative">
                    @csrf
                    <div class="flex gap-2">
                        <input name="nama_datel" class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="Tambah Datel Baru..." required>
                        <button type="submit" class="p-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </form>

                
                <div class="overflow-y-auto max-h-[400px] pr-2 space-y-2">
                    @forelse($datels as $datel)
                    <div x-data="{ editing: false, nama: '{{ addslashes($datel->nama_datel) }}' }" 
                         class="group flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition">
                        
                        
                        <span x-show="!editing" class="text-sm font-medium text-slate-700">{{ $datel->nama_datel }}</span>
                        
                        
                        <form x-show="editing" x-cloak method="POST" action="{{ route('admin.master-input.datel.update', $datel->id) }}" class="flex-1 flex gap-2 mr-2">
                            @csrf @method('PUT')
                            <input name="nama_datel" x-model="nama" class="w-full text-sm p-1 rounded border border-blue-300 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <button type="submit" class="text-green-600 hover:bg-green-100 p-1 rounded"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></button>
                        </form>

                        
                        <div x-show="!editing" class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editing = true" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button @click="$dispatch('open-confirm-delete-datel-{{ $datel->id }}')" class="p-1.5 text-red-600 hover:bg-red-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            <x-confirm-delete id="delete-datel-{{ $datel->id }}" title="Hapus Datel" message="Hapus '{{ $datel->nama_datel }}'?" :action="route('admin.master-input.datel.destroy', $datel->id)" />
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 text-sm py-4">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition flex flex-col h-full">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-2 h-8 bg-amber-500 rounded-full"></span>
                    STO
                </h3>
                <span class="text-xs font-semibold px-2 py-1 bg-slate-100 text-slate-600 rounded-lg">{{ $stos->count() }} Item</span>
            </div>
            
            <div class="p-6 flex-1 flex flex-col gap-6">
                
                <form method="POST" action="{{ route('admin.master-input.sto') }}" class="relative">
                    @csrf
                    <div class="flex gap-2">
                        <input name="nama_sto" class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-100 outline-none transition" placeholder="Tambah STO Baru..." required>
                        <button type="submit" class="p-2.5 bg-amber-500 text-white rounded-xl hover:bg-amber-600 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </form>

                
                <div class="overflow-y-auto max-h-[400px] pr-2 space-y-2">
                    @forelse($stos as $sto)
                    <div x-data="{ editing: false, nama: '{{ addslashes($sto->nama_sto) }}' }" 
                         class="group flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-amber-200 transition">
                        
                        <span x-show="!editing" class="text-sm font-medium text-slate-700">{{ $sto->nama_sto }}</span>
                        
                        <form x-show="editing" x-cloak method="POST" action="{{ route('admin.master-input.sto.update', $sto->id) }}" class="flex-1 flex gap-2 mr-2">
                            @csrf @method('PUT')
                            <input name="nama_sto" x-model="nama" class="w-full text-sm p-1 rounded border border-amber-300 focus:outline-none focus:ring-1 focus:ring-amber-500">
                            <button type="submit" class="text-green-600 hover:bg-green-100 p-1 rounded"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></button>
                        </form>

                        <div x-show="!editing" class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editing = true" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button @click="$dispatch('open-confirm-delete-sto-{{ $sto->id }}')" class="p-1.5 text-red-600 hover:bg-red-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            <x-confirm-delete id="delete-sto-{{ $sto->id }}" title="Hapus STO" message="Hapus '{{ $sto->nama_sto }}'?" :action="route('admin.master-input.sto.destroy', $sto->id)" />
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 text-sm py-4">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-md transition flex flex-col h-full">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-2 h-8 bg-green-500 rounded-full"></span>
                    Mitra
                </h3>
                <span class="text-xs font-semibold px-2 py-1 bg-slate-100 text-slate-600 rounded-lg">{{ $mitras->count() }} Item</span>
            </div>
            
            <div class="p-6 flex-1 flex flex-col gap-6">
                
                <form method="POST" action="{{ route('admin.master-input.mitra') }}" class="relative">
                    @csrf
                    <div class="flex gap-2">
                        <input name="nama_mitra" class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition" placeholder="Tambah Mitra Baru..." required>
                        <button type="submit" class="p-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </form>

                
                <div class="overflow-y-auto max-h-[400px] pr-2 space-y-2">
                    @forelse($mitras as $mitra)
                    <div x-data="{ editing: false, nama: '{{ addslashes($mitra->nama_mitra) }}' }" 
                         class="group flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-green-200 transition">
                        
                        <span x-show="!editing" class="text-sm font-medium text-slate-700">{{ $mitra->nama_mitra }}</span>
                        
                        <form x-show="editing" x-cloak method="POST" action="{{ route('admin.master-input.mitra.update', $mitra->id) }}" class="flex-1 flex gap-2 mr-2">
                            @csrf @method('PUT')
                            <input name="nama_mitra" x-model="nama" class="w-full text-sm p-1 rounded border border-green-300 focus:outline-none focus:ring-1 focus:ring-green-500">
                            <button type="submit" class="text-green-600 hover:bg-green-100 p-1 rounded"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></button>
                        </form>

                        <div x-show="!editing" class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editing = true" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button @click="$dispatch('open-confirm-delete-mitra-{{ $mitra->id }}')" class="p-1.5 text-red-600 hover:bg-red-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            <x-confirm-delete id="delete-mitra-{{ $mitra->id }}" title="Hapus Mitra" message="Hapus '{{ $mitra->nama_mitra }}'?" :action="route('admin.master-input.mitra.destroy', $mitra->id)" />
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 text-sm py-4">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
