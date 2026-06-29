@extends('layouts.app')

@section('title', 'Rincian Workload')

@section('content')
    <div class="flex flex-col gap-6">

        
        <div class="flex items-center gap-3 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}"
                class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
            <span class="text-slate-300 font-bold">❯</span>
            <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">Rincian Workload</span>
        </div>

        
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 relative">

            <div class="p-6 md:p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter & Pencarian Workload
                </h3>

                <form method="GET" action="{{ route('admin.workload') }}" class="space-y-6">
                    @if (request('date'))
                        <input type="hidden" name="date" value="{{ request('date') }}">
                    @endif
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        
                        
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Kata Kunci
                            </label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ $search }}"
                                    class="w-full rounded-xl border-slate-300 bg-slate-50 pl-10 pr-4 py-2.5 text-xs font-semibold text-slate-700 focus:bg-white
                                           focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                     placeholder="Cari Starclick ID / Customer...">
                                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Tahun
                            </label>
                            <select name="year" class="w-full rounded-xl border-slate-300 bg-slate-50 px-3 py-2.5 text-xs font-semibold text-slate-700 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition cursor-pointer">
                                <option value="all">Semua Tahun</option>
                                @foreach ($yearsList as $yr)
                                    <option value="{{ $yr }}" {{ $year == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                                @endforeach
                            </select>
                        </div>

                        
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Bulan
                            </label>
                            <select name="month" class="w-full rounded-xl border-slate-300 bg-slate-50 px-3 py-2.5 text-xs font-semibold text-slate-700 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition cursor-pointer">
                                <option value="all">Semua Bulan</option>
                                @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $mNum => $mName)
                                    <option value="{{ $mNum }}" {{ $month == $mNum ? 'selected' : '' }}>{{ $mName }}</option>
                                @endforeach
                            </select>
                        </div>

                        
                        <div class="relative" id="mitra-multiselect">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Mitra
                            </label>
                            <button type="button" onclick="toggleWorkloadMitraSelect()"
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 text-xs font-semibold py-2.5 px-3 text-left flex items-center justify-between transition hover:border-red-500 focus:bg-white">
                                <span id="mitra-label" class="truncate text-slate-700">
                                    @if (!empty($mitra)) 
                                        {{ is_array($mitra) ? count(array_filter($mitra)) : 1 }} Mitra dipilih
                                    @else 
                                        Semua Mitra 
                                    @endif
                                </span>
                                <svg class="w-4 h-4 shrink-0 ml-2 text-slate-400" id="mitra-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="mitra-dropdown" class="hidden absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-xl max-h-52 overflow-y-auto" style="min-width:200px;">
                                <div class="p-2 border-b border-slate-100">
                                    <input type="text" placeholder="Cari Mitra..." oninput="filterWorkloadMitraOptions(this.value)"
                                        class="w-full rounded-lg border-slate-200 text-xs py-1.5 px-2 focus:ring-red-500 focus:border-red-500 outline-none">
                                </div>
                                <div id="mitra-options" class="p-1">
                                    @php
                                        $selectedMitras = array_filter((array) $mitra);
                                    @endphp
                                    @foreach ($mitraList as $m)
                                        <label class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-red-50 cursor-pointer text-xs font-semibold text-slate-700 mitra-option" data-value="{{ strtolower($m) }}">
                                            <input type="checkbox" name="mitra[]" value="{{ $m }}"
                                                class="rounded border-slate-300 text-red-600 focus:ring-red-500"
                                                {{ in_array($m, $selectedMitras) ? 'checked' : '' }}
                                                onchange="updateWorkloadMitraLabel()">
                                            {{ $m }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    
                    <div class="flex items-center justify-between gap-4 pt-4 border-t border-slate-100">
                        
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs font-bold text-slate-500 mr-2">Progres:</span>
                            <div class="flex bg-slate-100 p-1 rounded-xl border border-slate-200">
                                <button type="button" onclick="setProgresFilter('')" 
                                    class="px-3 py-1.5 text-[9px] font-black uppercase tracking-wider rounded-lg transition-all {{ empty($progres) ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                                    Semua
                                </button>
                                @foreach ($stagesList as $stage)
                                    <button type="button" onclick="setProgresFilter('{{ $stage }}')" 
                                        class="px-3 py-1.5 text-[9px] font-black uppercase tracking-wider rounded-lg transition-all {{ $progres == $stage ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                                        {{ $stage }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="progres" id="progres-filter-input" value="{{ $progres }}">
                        </div>

                        
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.workload') }}" 
                                class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition">
                                Reset
                            </a>
                            <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white font-bold text-xs hover:shadow-lg hover:-translate-y-0.5 transition duration-300">
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2 flex-wrap">
                        Daftar Aktivitas & Rincian Kerja
                        @if (request('date'))
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                Tanggal: {{ \Carbon\Carbon::parse(request('date'))->locale('id')->isoFormat('D MMMM Y') }}
                            </span>
                        @endif
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">Total ditemukan {{ $logs->total() }} aktivitas update progress</p>
                </div>
            </div>

            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center w-16">No</th>
                            <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Update</th>
                            <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Starclick ID / NCX</th>
                            <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Customer</th>
                            <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Mitra</th>
                            <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Progres</th>
                            <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">STO / Datel</th>
                            <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Diupdate Oleh</th>
                            <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($logs as $index => $log)
                            @php
                                $progresName = strtoupper($log->progres);
                                $badgeClass = match ($progresName) {
                                    'ON DESK' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                    'SURVEY' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'PERIJINAN' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
                                    'DRM' => 'bg-teal-100 text-teal-800 border-teal-200',
                                    'APPROVED BY EBIS' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'MATDEV' => 'bg-green-100 text-green-800 border-green-200',
                                    'INSTALASI' => 'bg-lime-100 text-lime-800 border-lime-200',
                                    'SELESAI FISIK' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'GOLIVE' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'PS' => 'bg-orange-100 text-orange-800 border-orange-200',
                                    'KENDALA' => 'bg-red-100 text-red-800 border-red-200',
                                    'UJI TERIMA' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'REKON' => 'bg-pink-100 text-pink-800 border-pink-200',
                                    default => 'bg-slate-100 text-slate-800 border-slate-200',
                                };
                                $mitra = $log->planning->manualInput->nama_mitra 
                                    ?? $log->planning->nama_mitra 
                                    ?? 'Tanpa Mitra';
                                $customer = $log->planning->manualInput->nama_customer 
                                    ?? $log->planning->nama_customer 
                                    ?? '-';
                                $sto = $log->planning->manualInput->sto 
                                    ?? $log->planning->sto 
                                    ?? '-';
                                $datel = $log->planning->manualInput->datel 
                                    ?? $log->planning->datel 
                                    ?? '-';
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6 text-center font-bold text-slate-400 text-xs">
                                    {{ $logs->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-6 text-xs font-semibold text-slate-500">
                                    {{ \Carbon\Carbon::parse($log->created_at)->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-xs font-black text-slate-800">#{{ $log->planning->star_click_id ?? 'N/A' }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-xs font-bold text-slate-700 truncate max-w-[180px]">{{ $customer }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-xs font-semibold text-slate-600 truncate max-w-[120px]">{{ $mitra }}</div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider border {{ $badgeClass }}">
                                        {{ $log->progres }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-xs font-semibold text-slate-500">
                                    {{ strtoupper($sto) }} / {{ strtoupper($datel) }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 font-black text-[9px] flex items-center justify-center">
                                            {{ strtoupper(substr($log->user->name ?? '?', 0, 2)) }}
                                        </div>
                                        <span class="text-xs font-bold text-slate-600">{{ $log->user->name ?? 'System' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if ($log->planning && $log->planning->manualInput)
                                        <a href="{{ route('deployment.edit', $log->planning->manualInput->id) }}" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider hover:bg-blue-100 transition duration-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                    @else
                                        <span class="text-[10px] font-bold text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="text-xs font-bold uppercase tracking-widest">Tidak Ada Data Rincian Workload</p>
                                        <p class="text-[10px] text-slate-400 mt-1">Gunakan filter yang berbeda atau cari kata kunci lain</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <script>
        function setProgresFilter(value) {
            document.getElementById('progres-filter-input').value = value;
            // Submit form to apply filter immediately
            document.getElementById('progres-filter-input').closest('form').requestSubmit();
        }

        function toggleWorkloadMitraSelect() {
            const dropdown = document.getElementById('mitra-dropdown');
            const chevron = document.getElementById('mitra-chevron');
            if (!dropdown) return;
            const isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                dropdown.classList.remove('hidden');
                if (chevron) chevron.style.transform = 'rotate(180deg)';
            } else {
                dropdown.classList.add('hidden');
                if (chevron) chevron.style.removeProperty('transform');
            }
        }

        function updateWorkloadMitraLabel() {
            const checkboxes = document.querySelectorAll('#mitra-options input[type="checkbox"]:checked');
            const label = document.getElementById('mitra-label');
            if (!label) return;
            const count = checkboxes.length;
            if (count === 0) {
                label.textContent = 'Semua Mitra';
            } else {
                label.textContent = count + ' Mitra dipilih';
            }
        }

        function filterWorkloadMitraOptions(query) {
            const options = document.querySelectorAll('.mitra-option');
            const q = query.toLowerCase();
            options.forEach(opt => {
                const val = opt.getAttribute('data-value') || '';
                opt.style.display = val.includes(q) ? '' : 'none';
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const container = document.getElementById('mitra-multiselect');
            const dropdown = document.getElementById('mitra-dropdown');
            const chevron = document.getElementById('mitra-chevron');
            if (container && !container.contains(e.target)) {
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                    if (chevron) chevron.style.removeProperty('transform');
                }
            }
        });
    </script>
@endsection
