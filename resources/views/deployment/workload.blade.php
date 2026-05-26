@extends('layouts.app')

@section('title', 'Rincian Workload')

@section('content')
    <div class="flex flex-col gap-6">

        <!-- BREADCRUMBS -->
        <div class="flex items-center gap-3 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}"
                class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
            <span class="text-slate-300 font-bold">❯</span>
            <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">Rincian Workload</span>
        </div>

        <!-- FILTER CARD -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-red-600 rounded-t-3xl"></div>

            <div class="p-6 md:p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter & Pencarian Workload
                </h3>

                <form method="GET" action="{{ route('admin.workload') }}" class="space-y-6" data-turbo="false">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        
                        <!-- PENCARIAN -->
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

                        <!-- FILTER TAHUN -->
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

                        <!-- FILTER BULAN -->
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

                        <!-- FILTER MINGGU -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Minggu
                            </label>
                            <select name="week" class="w-full rounded-xl border-slate-300 bg-slate-50 px-3 py-2.5 text-xs font-semibold text-slate-700 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition cursor-pointer">
                                <option value="">Semua Minggu</option>
                                <option value="1" {{ $week == '1' ? 'selected' : '' }}>Minggu 1 (Tgl 1-7)</option>
                                <option value="2" {{ $week == '2' ? 'selected' : '' }}>Minggu 2 (Tgl 8-14)</option>
                                <option value="3" {{ $week == '3' ? 'selected' : '' }}>Minggu 3 (Tgl 15-21)</option>
                                <option value="4" {{ $week == '4' ? 'selected' : '' }}>Minggu 4 (Tgl 22-28)</option>
                                <option value="5" {{ $week == '5' ? 'selected' : '' }}>Minggu 5 (Tgl 29+)</option>
                            </select>
                        </div>

                        <!-- FILTER MITRA -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                Mitra
                            </label>
                            <select name="mitra" class="w-full rounded-xl border-slate-300 bg-slate-50 px-3 py-2.5 text-xs font-semibold text-slate-700 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition cursor-pointer">
                                <option value="">Semua Mitra</option>
                                @foreach ($mitraList as $m)
                                    <option value="{{ $m }}" {{ $mitra == $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="flex items-center justify-between gap-4 pt-4 border-t border-slate-100">
                        <!-- PROGRESS FILTER -->
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

                        <!-- BUTTON RUN / RESET -->
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

        <!-- TABLE CARD -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Daftar Aktivitas & Rincian Kerja</h3>
                    <p class="text-xs text-slate-400 mt-1">Total ditemukan {{ $logs->total() }} aktivitas update progress</p>
                </div>
            </div>

            <!-- TABLE CONTENT -->
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
                                    'SURVEY' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'PERIJINAN' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'MATDEV' => 'bg-sky-100 text-sky-800 border-sky-200',
                                    'INSTALASI' => 'bg-orange-100 text-orange-800 border-orange-200',
                                    'SELESAI FISIK' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
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

            <!-- PAGINATION -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <script>
        function setProgresFilter(value) {
            document.getElementById('progres-filter-input').value = value;
            // Submit form to apply filter immediately
            document.getElementById('progres-filter-input').closest('form').submit();
        }
    </script>
@endsection
