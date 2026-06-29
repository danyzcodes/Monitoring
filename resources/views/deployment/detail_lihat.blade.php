@extends('layouts.app')

@section('title', 'Detail Deployment')

@section('content')
<div class="flex flex-col gap-6" x-data="{ showImageModal: false, imageUrl: '' }">

    
    <template x-teleport="body">
        <div x-show="showImageModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center">
            
            <div x-show="showImageModal" x-transition.opacity duration.300ms class="absolute inset-0 bg-black/80 backdrop-blur-sm cursor-pointer" @click="showImageModal = false"></div>

            
            <div x-show="showImageModal" x-transition.scale.90 duration.300ms class="relative z-10 max-w-5xl max-h-[90vh] w-full p-4 flex items-center justify-center pointer-events-none">
                
                <button @click="showImageModal = false" class="absolute top-0 right-0 m-4 p-2 bg-black/60 hover:bg-black text-white rounded-full transition-colors z-20 pointer-events-auto">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <img :src="imageUrl" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl ring-1 ring-white/20 pointer-events-auto" @click.stop>
            </div>
        </div>
    </template>

    
   <div class="flex items-center gap-3 text-slate-500">

    <a href="{{ route('deployment.progress-overview') }}"
       class="font-bold text-slate-800 text-xs uppercase tracking-wider hover:text-red-600 transition">
       Progress Overview
    </a>

    <span class="text-slate-300 font-bold">❯</span>

    <a href="{{ route('deployment.lihat-data') }}"
       class="font-bold text-slate-800 text-xs uppercase tracking-wider hover:text-red-600 transition">
       Lihat Data
    </a>

    <span class="text-slate-300 font-bold">❯</span>

    <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">
       Detail Deployment
    </span>

</div>

    
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden" style="border-color:#fde8e8; box-shadow: 0 4px 20px rgba(227,43,43,0.06);">

        
        <div class="px-8 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between" x-data="{ showRiwayat: false }">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Detail Deployment</h2>
                <p class="text-sm text-slate-500 mt-0.5">{{ \App\Helpers\MaskHelper::mask($data->nama_customer) }}</p>
            </div>
            <div class="flex items-center gap-3">
                <x-status-badge :value="$data->progres" />
                <button @click="showRiwayat = true"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold
                           bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-sm
                           hover:from-blue-600 hover:to-blue-700 hover:shadow-md transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Order
                </button>
            </div>

            
            <template x-teleport="body">
                <div x-show="showRiwayat" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center">
                    
                    <div x-show="showRiwayat" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                         class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showRiwayat = false"></div>

                    
                    <div x-show="showRiwayat" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                         class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[85vh] flex flex-col relative z-10 mx-4">

                        
                        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-blue-50 to-white rounded-t-2xl">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Daftar Riwayat Proses Order</h3>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <p class="text-xs text-slate-500">{{ \App\Helpers\MaskHelper::mask($data->nama_customer) }} &mdash; {{ \App\Helpers\MaskHelper::mask($data->star_click_id) }}</p>
                                    @if($data->created_at)
                                        @php
                                            $isSelesai = in_array(strtolower(optional($data->planning)->status_order ?? ''), ['selesai', 'closed', 'cancel', 'drop', 'completed']);
                                            $akhir = ($isSelesai && $data->tanggal_update_progres) ? \Carbon\Carbon::parse($data->tanggal_update_progres) : now();
                                            $diffUsia = $data->created_at->diff($akhir);
                                            $usiaArr = [];
                                            if ($diffUsia->d > 0) $usiaArr[] = $diffUsia->d . ' hr';
                                            if ($diffUsia->h > 0) $usiaArr[] = $diffUsia->h . ' jam';
                                            if ($diffUsia->i > 0) $usiaArr[] = $diffUsia->i . ' mnt';
                                            $strUsiaOrder = empty($usiaArr) ? 'Baru saja' : implode(' ', $usiaArr);
                                        @endphp
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="inline-flex items-center gap-1 font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 text-[10px]">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Usia Order: {{ $strUsiaOrder }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <button @click="showRiwayat = false" class="p-2 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        
                        <div class="overflow-y-auto flex-1">
                            @php
                                $logs = optional($data->planning)->logs ?? collect();
                            @endphp

                            @if($logs->count() > 0)
                            <table class="w-full text-sm">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-5 py-3 font-semibold text-left">Pada</th>
                                        <th class="px-5 py-3 font-semibold text-left">Oleh</th>
                                        <th class="px-5 py-3 font-semibold text-left">Sebelum</th>
                                        <th class="px-5 py-3 font-semibold text-left">Setelah</th>
                                        <th class="px-5 py-3 font-semibold text-left">Durasi</th>
                                        <th class="px-5 py-3 font-semibold text-left">Usia Order</th>
                                        <th class="px-5 py-3 font-semibold text-left">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($logs as $index => $log)
                                    @php
                                        // Calculate duration to next log (or to now for the latest)
                                        $nextLog = $logs->get($index + 1);
                                        if ($nextLog) {
                                            $duration = $log->created_at->diff($nextLog->created_at);
                                        } else {
                                            $duration = null;
                                        }

                                        // Previous progress (the log below in chronological order = next in desc order)
                                        $previousProgres = $nextLog ? $nextLog->progres : null;
                                    @endphp
                                    <tr class="hover:bg-blue-50/30 transition">
                                        
                                        <td class="px-5 py-4 whitespace-nowrap align-middle">
                                            <div class="font-medium text-slate-700 text-xs">{{ $log->created_at->format('Y-m-d H:i:s') }}</div>
                                            <div class="mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-50 text-blue-600 border border-blue-100">
                                                    {{ $log->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </td>

                                        
                                        <td class="px-5 py-4 align-middle" style="white-space:nowrap;">
                                            <div style="display:inline-flex;align-items:center;gap:8px;">
                                                <div style="width:28px;height:28px;min-width:28px;border-radius:50%;background:linear-gradient(135deg,#94a3b8,#475569);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700;">
                                                    {{ strtoupper(substr(optional($log->user)->name ?? '?', 0, 1)) }}
                                                </div>
                                                <span style="font-weight:600;font-size:12px;color:#334155;">{{ optional($log->user)->name ?? '-' }}</span>
                                            </div>
                                        </td>

                                        
                                        <td class="px-5 py-4 whitespace-nowrap align-middle">
                                            @if($previousProgres)
                                                <x-status-badge :value="$previousProgres" />
                                            @else
                                                <span class="text-xs text-slate-400 italic">—</span>
                                            @endif
                                        </td>

                                        
                                        <td class="px-5 py-4 whitespace-nowrap align-middle">
                                            <x-status-badge :value="$log->progres" />
                                        </td>

                                        
                                        <td class="px-5 py-4 whitespace-nowrap align-middle">
                                            @if($duration)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-slate-50 text-slate-600 border border-slate-200">
                                                    @if($duration->d > 0) {{ $duration->d }} hari @endif
                                                    @if($duration->h > 0) {{ $duration->h }} jam @endif
                                                    {{ $duration->i }} menit
                                                </span>
                                            @else
                                                <span class="text-xs text-slate-400 italic">—</span>
                                            @endif
                                        </td>

                                        
                                        <td class="px-5 py-4 whitespace-nowrap align-middle">
                                            @if($data->created_at)
                                                @php
                                                    $diffAg = $data->created_at->diff($log->created_at);
                                                    $agArr = [];
                                                    if ($diffAg->d > 0) $agArr[] = $diffAg->d . ' hari';
                                                    if ($diffAg->h > 0) $agArr[] = $diffAg->h . ' jam';
                                                    if ($diffAg->i > 0) $agArr[] = $diffAg->i . ' mnt';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-blue-50 text-blue-600 border border-blue-100">
                                                    {{ empty($agArr) ? 'Baru saja' : implode(' ', $agArr) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-slate-400 italic">—</span>
                                            @endif
                                        </td>

                                        
                                        <td class="px-5 py-4 align-middle">
                                            <div class="text-xs text-slate-600 max-w-[200px] truncate" title="{{ $log->keterangan ?? '-' }}">
                                                {{ $log->keterangan ?? '-' }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="flex flex-col items-center justify-center py-16">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-slate-700">Belum ada riwayat</h3>
                                <p class="text-slate-500 mt-1 text-sm">Belum ada perubahan progres yang tercatat untuk order ini.</p>
                            </div>
                            @endif
                        </div>

                        
                        <div class="px-6 py-4 bg-slate-50 rounded-b-2xl border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs text-slate-400">Total: {{ $logs->count() }} riwayat</span>
                            <button @click="showRiwayat = false" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition shadow-sm text-sm">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        
        <div class="p-8 space-y-8">

            
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100">Informasi Pelanggan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                    <div>
                        <div class="text-slate-500 text-xs mb-1">NDE JT</div>
                        <div class="font-medium text-slate-800">{{ \App\Helpers\MaskHelper::mask($data->nde_jt) }}</div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Starclick ID</div>
                        <div class="font-medium text-slate-800">{{ \App\Helpers\MaskHelper::mask($data->star_click_id) }}</div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Nama Pelanggan</div>
                        <div class="font-medium text-slate-800">{{ \App\Helpers\MaskHelper::mask($data->nama_customer) }}</div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Nama Mitra</div>
                        <div class="font-medium text-slate-800">{{ \App\Helpers\MaskHelper::mask($data->nama_mitra) }}</div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Telepon</div>
                        <div class="font-medium text-slate-800">{{ \App\Helpers\MaskHelper::mask($data->telepon_pelanggan) }}</div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Tikor</div>
                        <div class="font-medium text-slate-800 font-mono text-xs">{{ \App\Helpers\MaskHelper::mask($data->tikor_pelanggan) }}</div>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <div class="text-slate-500 text-xs mb-1">Alamat</div>
                        <div class="font-medium text-slate-800">{{ \App\Helpers\MaskHelper::mask($data->alamat_pelanggan) }}</div>
                    </div>
                </div>
            </div>

            
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100">Detail Lokasi & Teknis</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Datel</div>
                        <div class="font-medium text-slate-800">{{ \App\Helpers\MaskHelper::mask($data->datel) }}</div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">STO</div>
                        <div class="font-medium text-slate-800">{{ $data->sto ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Status Order</div>
                        <x-status-badge :value="optional($data->planning)->status_order" mask />
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Status Alokasi</div>
                        <x-status-badge :value="optional($data->planning)->status_alokasi_alpro" mask />
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Tipe Desain</div>
                        <div class="font-medium text-slate-800">{{ \App\Helpers\MaskHelper::mask(optional($data->planning)->tipe_desain) }}</div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Jenis Program</div>
                        <x-status-badge :value="optional($data->planning)->jenis_program" mask />
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">LoP ID</div>
                        <div class="font-medium text-slate-800">{{ \App\Helpers\MaskHelper::mask(optional($data->planning)->ihld_lop_id) }}</div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Total BOQ</div>
                        <div class="font-medium text-slate-800 font-mono">
                            {{ optional($data->planning)->total_boq ? \App\Helpers\MaskHelper::mask(number_format(optional($data->planning)->total_boq, 0, ',', '.')) : '-' }}
                        </div>
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">CFU</div>
                        <x-status-badge :value="optional($data->planning)->cfu" mask />
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Nama CFU</div>
                        <x-status-badge :value="optional($data->planning)->nama_cfu" mask />
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Status Proyek</div>
                        <x-status-badge :value="optional($data->planning)->status_proyek" mask />
                    </div>
                    <div>
                        <div class="text-slate-500 text-xs mb-1">Keterangan</div>
                        <div class="font-medium text-slate-800">{{ $data->keterangan ?? '-' }}</div>
                    </div>
                </div>
            </div>

            
            @php
                $timelineLogs = optional($data->planning)->logs ? optional($data->planning)->logs->sortBy('created_at')->values() : collect();
            @endphp

            @if($timelineLogs->count() > 0)
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-6 pb-2 border-b border-slate-100">
                    Timeline Progres ({{ $timelineLogs->count() }} tahap)
                </h4>

                <div class="relative">
                    
                    <div class="absolute left-[18px] top-2 bottom-2 w-0.5 bg-gradient-to-b from-red-200 via-red-300 to-red-200 rounded-full"></div>

                    <div class="space-y-0">
                        @foreach($timelineLogs as $stepIndex => $log)
                        @php
                            $logData = is_array($log->data) ? $log->data : [];
                            // Extract evidence images for this step — only show evidence relevant to THIS step
                            $stepKey = strtolower(str_replace(' ', '_', $log->progres));
                            $evidences = collect($logData)->filter(function($v, $k) use ($stepKey) {
                                return $v && str_contains($k, 'evidence') && !str_starts_with($k, 'link_') && str_contains($k, $stepKey);
                            });
                            // Extract links
                            $links = collect($logData)->filter(function($v, $k) {
                                return $v && (str_starts_with($k, 'link_') || (is_string($v) && str_starts_with($v, 'http')));
                            });
                            // Extract other data
                            $otherData = collect($logData)->filter(function($v, $k) {
                                return $v && !str_contains($k, 'evidence') && !str_starts_with($k, 'link_') && !str_starts_with($v ?? '', 'http') && !in_array($k, ['commitment_date', 'commitment_updated_by']);
                            });
                            $isLast = $stepIndex === $timelineLogs->count() - 1;
                        @endphp
                        <div class="relative flex gap-5 pb-8 {{ $isLast ? 'pb-0' : '' }}">
                            
                            <div class="relative z-0 shrink-0">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold shadow-sm
                                    {{ $isLast ? 'bg-gradient-to-br from-red-500 to-red-600 text-white ring-4 ring-red-100' : 'bg-white border-2 border-red-300 text-red-600' }}">
                                    {{ $stepIndex + 1 }}
                                </div>
                            </div>

                            
                            <div class="flex-1 bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden {{ $isLast ? 'ring-1 ring-red-100' : '' }}">
                                
                                <div class="px-5 py-3 bg-gradient-to-r {{ $isLast ? 'from-red-50 to-white' : 'from-slate-50 to-white' }} border-b border-slate-100 flex items-center justify-between flex-wrap gap-2">
                                    <div class="flex items-center gap-3">
                                        <x-status-badge :value="$log->progres" />
                                        @if($isLast)
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-red-500 bg-red-50 px-2 py-0.5 rounded-md border border-red-100">Terkini</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-slate-500">
                                        
                                        <div class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2H5a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2z" />
                                            </svg>
                                            {{ $log->created_at->format('d M Y, H:i') }}
                                        </div>
                                        
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-5 h-5 rounded-full bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center text-white text-[9px] font-bold">
                                                {{ strtoupper(substr(optional($log->user)->name ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-slate-600">{{ optional($log->user)->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="px-5 py-4">
                                    
                                    @if($log->keterangan)
                                    <div class="mb-4">
                                        <div class="text-xs text-slate-500 mb-1">Keterangan</div>
                                        <div class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $log->keterangan }}</div>
                                    </div>
                                    @endif

                                    
                                    @if($evidences->count() > 0)
                                    <div class="mb-4">
                                        <div class="text-xs text-slate-500 mb-2">Evidence</div>
                                        <div class="flex flex-wrap gap-3">
                                            @foreach($evidences as $eKey => $ePath)
                                            <div class="group relative">
                                                <img src="{{ asset('storage/' . $ePath) }}" loading="lazy"
                                                     class="h-14 w-auto rounded border border-slate-200 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.1)] cursor-zoom-in group-hover:shadow-[0_4px_12px_-4px_rgba(227,43,43,0.3)] group-hover:border-red-200 transition-all duration-300"
                                                     @click.prevent="imageUrl = '{{ asset('storage/' . $ePath) }}'; showImageModal = true"
                                                     title="{{ str_replace('_', ' ', $eKey) }}">
                                                <div class="absolute bottom-1 left-1 opacity-0 group-hover:opacity-100 px-1.5 py-0.5 bg-black/70 text-white text-[9px] rounded font-medium capitalize transition-opacity pointer-events-none">
                                                    {{ str_replace(['evidence_', '_'], ['', ' '], $eKey) }}
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    
                                    @if($links->count() > 0)
                                    <div class="mb-3">
                                        <div class="text-xs text-slate-500 mb-2">Link</div>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($links as $lKey => $lValue)
                                            <a href="{{ $lValue }}" target="_blank"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-semibold hover:bg-blue-100 transition border border-blue-100">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                {{ ucwords(str_replace('_', ' ', $lKey)) }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    
                                    @if($otherData->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        @foreach($otherData as $oKey => $oValue)
                                        <div>
                                            <div class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">{{ str_replace('_', ' ', $oKey) }}</div>
                                            <div class="text-xs font-medium text-slate-700">{{ $oValue }}</div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif

                                    @if(!$log->keterangan && $evidences->count() === 0 && $links->count() === 0 && $otherData->count() === 0)
                                    <div class="text-xs text-slate-400 italic">Tidak ada data tambahan</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @elseif(!empty($data->data) && is_array($data->data))
            
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100">
                    Evidence & Progres ({{ $data->progres }})
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($data->data as $key => $value)
                        @if($value && $key !== 'commitment_updated_by')
                            <div class="flex flex-col gap-2">
                                <div class="text-sm font-medium text-slate-700 capitalize">{{ str_replace('_', ' ', $key) }}</div>
                                @if(str_contains($key, 'evidence') && !str_starts_with($key, 'link_'))
                                    <div class="relative group w-fit">
                                        <img src="{{ asset('storage/' . $value) }}" loading="lazy"
                                             class="h-20 w-auto rounded-lg border border-slate-200 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.1)] cursor-zoom-in group-hover:shadow-[0_4px_12px_-4px_rgba(227,43,43,0.3)] group-hover:border-red-200 transition-all duration-300"
                                             @click.prevent="imageUrl = '{{ asset('storage/' . $value) }}'; showImageModal = true">
                                             
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors rounded-lg flex items-center justify-center pointer-events-none">
                                            <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                        </div>
                                    </div>
                                @elseif(str_starts_with($key, 'link_') || str_starts_with($value, 'http'))
                                    <a href="{{ $value }}" target="_blank"
                                       class="text-blue-600 hover:text-blue-700 hover:underline text-sm break-all flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Buka Link
                                    </a>
                                @else
                                    <div class="text-sm text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $value }}</div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            
            @if($data->link_dokumen)
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100">Link Dokumen</h4>
                <a href="{{ $data->link_dokumen }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-600 text-sm font-semibold hover:bg-blue-100 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Buka Dokumen
                </a>
            </div>
            @endif

        </div>

        
        <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
            <span>Dibuat: {{ $data->created_at?->format('d M Y, H:i') ?? '-' }}</span>
            @if($data->tanggal_update_progres)
                <span>Update terakhir: {{ \Carbon\Carbon::parse($data->tanggal_update_progres)->format('d M Y, H:i') }}</span>
            @endif
        </div>

    </div>
</div>
@endsection
