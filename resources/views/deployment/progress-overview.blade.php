@extends('layouts.app')

@section('title', 'Progress Overview')

@section('content')
    <div class="flex flex-col gap-6">

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-3 text-sm text-slate-500">
            <a href="{{ route('dashboard') }}" class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
            <span class="text-slate-300 font-bold">❯</span>
            <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">Progress Overview</span>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-6 relative overflow-hidden"
            style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%); border-radius: 2rem;">
            {{-- Decorative blob --}}
            <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full blur-3xl opacity-30" style="background:#e32b2b;">
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-1">
                    <div class="p-2 rounded-xl" style="background:rgba(227,43,43,0.25);">
                        <svg class="w-5 h-5" style="color:#fca5a5;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-[0.25em]" style="color:#fca5a5;">Progress
                        Overview</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">Monitoring Progress Deployment</h1>
                <p class="text-xs mt-1" style="color:#94a3b8;">Grafik distribusi tahapan progress seluruh deployment</p>
            </div>

            {{-- Live Clock & Actions --}}
            <div class="relative z-10 flex flex-col sm:flex-row items-end sm:items-center gap-6 mt-4 sm:mt-0">
                <div class="text-right hidden sm:flex flex-col items-end">
                    <div id="live-date" class="text-xs font-semibold mb-1" style="color:#94a3b8;"></div>
                    <div id="live-clock" class="text-4xl font-black text-white tabular-nums tracking-tight"
                        style="font-variant-numeric: tabular-nums;"></div>
                    <div class="text-[10px] mt-1 font-bold uppercase tracking-widest" style="color:#6b7280;">WIB · Indonesia
                    </div>
                </div>
            </div>
        </div>



        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            {{-- Total Deployment --}}
            <a href="{{ route('deployment.update') }}"
                class="bg-white rounded-2xl p-5 shadow-sm border relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 block"
                style="border-color:#fde8e8; box-shadow: 0 4px 20px rgba(227,43,43,0.06);">
                <div class="absolute -top-6 -right-6 w-20 h-20 rounded-full blur-2xl opacity-20"
                    style="background:#e32b2b;"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="p-2 rounded-xl" style="background:#fef2f2;">
                            <svg class="w-4 h-4" style="color:#e32b2b;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest" style="color:#9ca3af;">Total</span>
                    </div>
                    <p class="text-3xl font-black tracking-tight" style="color:#1a1a2e;">{{ number_format($totalAll) }}</p>
                    <p class="text-[10px] font-bold mt-1" style="color:#9ca3af;">Seluruh Deployment</p>
                </div>
            </a>

            {{-- On Track --}}
            <a href="{{ route('deployment.update', ['filter_key' => 'progres', 'filter_values' => 'ON DESK,SURVEY,PERIJINAN,DRM,APPROVED BY EBIS,MATDEV,INSTALASI,SELESAI FISIK']) }}"
                class="bg-white rounded-2xl p-5 shadow-sm border relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 block"
                style="border-color:#d1fae5; box-shadow: 0 4px 20px rgba(16,185,129,0.06);">
                <div class="absolute -top-6 -right-6 w-20 h-20 rounded-full blur-2xl opacity-20"
                    style="background:#10b981;"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="p-2 rounded-xl" style="background:#ecfdf5;">
                            <svg class="w-4 h-4" style="color:#10b981;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest" style="color:#9ca3af;">On Track</span>
                    </div>
                    <p class="text-3xl font-black tracking-tight" style="color:#065f46;">{{ number_format($totalOnTrack) }}
                    </p>
                    <p class="text-[10px] font-bold mt-1" style="color:#9ca3af;">Berjalan Normal</p>
                </div>
            </a>

            {{-- Selesai / Final Stages --}}
            <a href="{{ route('deployment.update', ['filter_key' => 'progres', 'filter_values' => 'GOLIVE,PS,UJI TERIMA,REKON']) }}"
                class="bg-white rounded-2xl p-5 shadow-sm border relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 block"
                style="border-color:#dbeafe; box-shadow: 0 4px 20px rgba(59,130,246,0.06);">
                <div class="absolute -top-6 -right-6 w-20 h-20 rounded-full blur-2xl opacity-20"
                    style="background:#3b82f6;"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="p-2 rounded-xl" style="background:#eff6ff;">
                            <svg class="w-4 h-4" style="color:#3b82f6;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest" style="color:#9ca3af;">Finish</span>
                    </div>
                    <p class="text-3xl font-black tracking-tight" style="color:#1e40af;">
                        {{ number_format($totalSelesai) }}</p>
                    <p class="text-[10px] font-bold mt-1" style="color:#9ca3af;">Tahap Akhir & Done</p>
                </div>
            </a>

            {{-- Overdue --}}
            <a href="{{ route('deployment.update', ['usia' => 'overdue']) }}"
                class="bg-white rounded-2xl p-5 shadow-sm border relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 block"
                style="border-color:#fee2e2; box-shadow: 0 4px 20px rgba(239,68,68,0.06);">
                <div class="absolute -top-6 -right-6 w-20 h-20 rounded-full blur-2xl opacity-20"
                    style="background:#ef4444;"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="p-2 rounded-xl" style="background:#fef2f2;">
                            <svg class="w-4 h-4" style="color:#ef4444;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest"
                            style="color:#9ca3af;">OVERDUE</span>
                    </div>
                    <p class="text-3xl font-black tracking-tight" style="color:#991b1b;">
                        {{ number_format($totalOverdue) }}</p>
                    <p class="text-[10px] font-bold mt-1" style="color:#9ca3af;">Melewati Commitment Date</p>
                </div>
            </a>

        </div>

        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl border"
            style="border-color:#fde8e8; box-shadow: 0 20px 40px rgba(227,43,43,0.06);">
            <div class="flex items-center gap-4 mb-6">
                <div class="p-3 rounded-2xl" style="background:#fef2f2; color:#e32b2b;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold tracking-tight" style="color:#1a1a2e;">Filter Data</h3>
                    <p class="text-[10px] font-bold uppercase tracking-widest mt-0.5" style="color:#9ca3af;">Filter
                        berdasarkan Tanggal, STO, Datel, atau Mitra</p>
                </div>
            </div>

            <form method="GET" action="{{ route('deployment.progress-overview') }}" id="filterForm">
                <div class="flex flex-wrap items-end gap-3 p-4 rounded-2xl border"
                    style="background:#fafafa; border-color:#f3f4f6;">

                    {{-- STO Multi-Select --}}
                    <div class="flex-1 min-w-[150px] relative" id="sto-multiselect">
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1"
                            style="color:#9ca3af;">STO</label>
                        <button type="button" onclick="toggleMultiSelect('sto')"
                            class="w-full rounded-xl border border-slate-200 bg-white text-xs font-semibold py-2 px-3 text-left flex items-center justify-between transition hover:border-red-300 focus:ring-red-500 focus:border-red-500">
                            <span id="sto-label" class="truncate">
                                @if (!empty($filterStoArr))
                                    {{ count($filterStoArr) }} STO dipilih
                                @else
                                    Semua STO
                                @endif
                            </span>
                            <svg class="w-4 h-4 shrink-0 ml-2 transition-transform" style="color:#9ca3af;"
                                id="sto-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="sto-dropdown"
                            class="hidden absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-xl max-h-52 overflow-y-auto"
                            style="min-width:180px;">
                            <div class="p-2 border-b" style="border-color:#f3f4f6;">
                                <input type="text" placeholder="Cari STO..."
                                    oninput="filterOptions('sto', this.value)"
                                    class="w-full rounded-lg border-slate-200 text-xs py-1.5 px-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div id="sto-options" class="p-1">
                                @foreach ($stoList as $sto)
                                    <label
                                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-red-50 cursor-pointer text-xs font-semibold sto-option"
                                        data-value="{{ strtolower($sto) }}">
                                        <input type="checkbox" name="sto[]" value="{{ $sto }}"
                                            class="rounded border-slate-300 text-red-600 focus:ring-red-500"
                                            {{ in_array($sto, $filterStoArr ?? []) ? 'checked' : '' }}
                                            onchange="updateMultiLabel('sto')">
                                        {{ strtoupper($sto) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Datel Multi-Select --}}
                    <div class="flex-1 min-w-[150px] relative" id="datel-multiselect">
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1"
                            style="color:#9ca3af;">Datel</label>
                        <button type="button" onclick="toggleMultiSelect('datel')"
                            class="w-full rounded-xl border border-slate-200 bg-white text-xs font-semibold py-2 px-3 text-left flex items-center justify-between transition hover:border-red-300 focus:ring-red-500 focus:border-red-500">
                            <span id="datel-label" class="truncate">
                                @if (!empty($filterDatelArr))
                                    {{ count($filterDatelArr) }} Datel dipilih
                                @else
                                    Semua Datel
                                @endif
                            </span>
                            <svg class="w-4 h-4 shrink-0 ml-2 transition-transform" style="color:#9ca3af;"
                                id="datel-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="datel-dropdown"
                            class="hidden absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-xl max-h-52 overflow-y-auto"
                            style="min-width:180px;">
                            <div class="p-2 border-b" style="border-color:#f3f4f6;">
                                <input type="text" placeholder="Cari Datel..."
                                    oninput="filterOptions('datel', this.value)"
                                    class="w-full rounded-lg border-slate-200 text-xs py-1.5 px-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div id="datel-options" class="p-1">
                                @foreach ($datelList as $datel)
                                    <label
                                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-red-50 cursor-pointer text-xs font-semibold datel-option"
                                        data-value="{{ strtolower($datel) }}">
                                        <input type="checkbox" name="datel[]" value="{{ $datel }}"
                                            class="rounded border-slate-300 text-red-600 focus:ring-red-500"
                                            {{ in_array($datel, $filterDatelArr ?? []) ? 'checked' : '' }}
                                            onchange="updateMultiLabel('datel')">
                                        {{ $datel }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Mitra Multi-Select --}}
                    <div class="flex-1 min-w-[150px] relative" id="mitra-multiselect">
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1"
                            style="color:#9ca3af;">Mitra</label>
                        <button type="button" onclick="toggleMultiSelect('mitra')"
                            class="w-full rounded-xl border border-slate-200 bg-white text-xs font-semibold py-2 px-3 text-left flex items-center justify-between transition hover:border-red-300 focus:ring-red-500 focus:border-red-500">
                            <span id="mitra-label" class="truncate">
                                @if (!empty($filterMitraArr))
                                    {{ count($filterMitraArr) }} Mitra dipilih
                                @else
                                    Semua Mitra
                                @endif
                            </span>
                            <svg class="w-4 h-4 shrink-0 ml-2 transition-transform" style="color:#9ca3af;"
                                id="mitra-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="mitra-dropdown"
                            class="hidden absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-xl max-h-52 overflow-y-auto"
                            style="min-width:180px;">
                            <div class="p-2 border-b" style="border-color:#f3f4f6;">
                                <input type="text" placeholder="Cari Mitra..."
                                    oninput="filterOptions('mitra', this.value)"
                                    class="w-full rounded-lg border-slate-200 text-xs py-1.5 px-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div id="mitra-options" class="p-1">
                                @foreach ($mitraList as $mitra)
                                    <label
                                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-red-50 cursor-pointer text-xs font-semibold mitra-option"
                                        data-value="{{ strtolower($mitra) }}">
                                        <input type="checkbox" name="mitra[]" value="{{ $mitra }}"
                                            class="rounded border-slate-300 text-red-600 focus:ring-red-500"
                                            {{ in_array($mitra, $filterMitraArr ?? []) ? 'checked' : '' }}
                                            onchange="updateMultiLabel('mitra')">
                                        {{ $mitra }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Progress A (Dari) --}}
                    <div class="min-w-[150px]">
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1"
                            style="color:#9ca3af;">Progress (Dari)</label>
                        <select name="prog_a"
                            class="w-full rounded-xl border-slate-200 bg-white text-xs font-semibold py-2 px-3 focus:ring-red-500 focus:border-red-500 transition">
                            <option value="">Pilih Progress</option>
                            @foreach ($stages as $stage)
                                <option value="{{ $stage }}" {{ ($progA ?? '') == $stage ? 'selected' : '' }}>
                                    {{ $stage }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Progress B (Ke) --}}
                    <div class="min-w-[150px]">
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1"
                            style="color:#9ca3af;">Progress (Ke)</label>
                        <select name="prog_b"
                            class="w-full rounded-xl border-slate-200 bg-white text-xs font-semibold py-2 px-3 focus:ring-red-500 focus:border-red-500 transition">
                            <option value="">Pilih Progress</option>
                            @foreach ($stages as $stage)
                                <option value="{{ $stage }}" {{ ($progB ?? '') == $stage ? 'selected' : '' }}>
                                    {{ $stage }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider text-white transition hover:shadow-lg hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, #e32b2b 0%, #b91c1c 100%);">
                            Filter
                        </button>
                        @if ($hasFilter)
                            <a href="{{ route('deployment.progress-overview') }}"
                                class="px-3 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider transition hover:bg-red-50"
                                style="color:#e32b2b; border: 1px solid #fde8e8;">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            {{-- Average Duration Info --}}
            @if (isset($avgDurationAB))
                <div class="mt-4 p-4 rounded-xl flex items-center gap-3"
                    style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe;">
                    <div class="p-2 rounded-lg bg-white bg-opacity-60 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">
                            Rata-rata Durasi dari <span class="text-blue-700 font-extrabold">{{ $progA }}</span> ke
                            <span class="text-blue-700 font-extrabold">{{ $progB }}</span>
                        </p>
                        <p class="text-xl font-black text-blue-800 tracking-tight mt-0.5">{{ $avgDurationAB }}</p>
                    </div>
                </div>
            @endif

            {{-- Filter Result Info --}}
            @if ($hasFilter)
                <div class="mt-6 pt-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
                    style="border-top: 1px solid #fef2f2;">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl" style="background:#fef2f2;">
                            <svg class="w-5 h-5" style="color:#e32b2b;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold" style="color:#374151;">
                                Hasil Filter: <span class="text-lg font-black"
                                    style="color:#e32b2b;">{{ number_format($totalAll) }}</span> order
                            </p>
                            @if (!empty($filterStoArr))
                                STO: {{ implode(', ', array_map('strtoupper', $filterStoArr)) }}
                            @endif
                            @if (!empty($filterDatelArr))
                                {{ !empty($filterStoArr) ? '·' : '' }} Datel: {{ implode(', ', $filterDatelArr) }}
                            @endif
                            @if (!empty($filterMitraArr))
                                {{ !empty($filterStoArr) || !empty($filterDatelArr) ? '·' : '' }} Mitra:
                                {{ implode(', ', $filterMitraArr) }}
                            @endif
                            @if (!empty($progA) && !empty($progB))
                                {{ !empty($filterStoArr) || !empty($filterDatelArr) || !empty($filterMitraArr) ? '·' : '' }}
                                Progress: {{ $progA }} s/d {{ $progB }}
                            @endif
                        </div>
                    </div>
                    @if ($topProgress)
                        <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl"
                            style="background: linear-gradient(135deg, #fef2f2 0%, #fff1f2 100%); border: 1px solid #fde8e8;">
                            <svg class="w-4 h-4" style="color:#e32b2b;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="text-xs font-bold" style="color:#374151;">Terbanyak di <span class="font-black"
                                    style="color:#e32b2b;">{{ $topProgress }}</span> —
                                {{ number_format($topProgressCount) }} order</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- ===== STACKED BAR CHART ===== --}}
        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl border"
            style="border-color:#fde8e8; box-shadow: 0 20px 40px rgba(227,43,43,0.06);">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-2xl" style="background:#fef2f2; color:#e32b2b;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold tracking-tight" style="color:#1a1a2e;">Datel & Progress
                            Distribution</h3>
                        <p class="text-[10px] font-bold uppercase tracking-widest mt-0.5" style="color:#9ca3af;">Komposisi
                            tahapan progress per Datel</p>
                    </div>
                </div>
                <div class="text-[10px] font-bold px-3 py-1.5 rounded-xl" style="color:#e32b2b; background:#fef2f2;">
                    {{ $totalAll }} Total Deployment
                </div>
            </div>

            <div class="relative w-full" style="height: 280px;">
                <canvas id="stackedChart"></canvas>
            </div>
        </div>

        {{-- ===== iHLD STATUS ORDER CHART ===== --}}
        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl border mt-6"
            style="border-color:#e0e7ff; box-shadow: 0 20px 40px rgba(79,70,229,0.06);">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-2xl" style="background:#eef2ff; color:#4f46e5;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold tracking-tight" style="color:#1a1a2e;">iHLD Status Order</h3>
                        <p class="text-[10px] font-bold uppercase tracking-widest mt-0.5" style="color:#9ca3af;">
                            Distribusi order berdasarkan status iHLD</p>
                    </div>
                </div>
            </div>

            <div class="relative w-full" style="height: 280px;">
                <canvas id="ihldChart"></canvas>
            </div>
        </div>

        {{-- ===== RATA-RATA DURASI SELESAI PER MITRA CHART ===== --}}
        <div class="bg-white rounded-[2.5rem] p-6 sm:p-8 shadow-xl border mt-6 relative overflow-hidden"
            style="border-color:#fde8e8; box-shadow: 0 20px 50px rgba(227,43,43,0.08);">
            {{-- Decorative gradient accent --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-red-50 to-transparent rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="p-3.5 rounded-2xl shadow-lg" style="background: linear-gradient(135deg, #fef2f2, #fee2e2); color:#e32b2b;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold tracking-tight" style="color:#1a1a2e;">Rata-rata Durasi Selesai
                            per Mitra</h3>
                        <p class="text-[10px] font-bold uppercase tracking-widest mt-0.5" style="color:#9ca3af;">Lama
                            waktu dari input hingga Order Selesai</p>
                    </div>
                </div>
            </div>

            {{-- Full Width Chart --}}
            <div class="relative w-full h-[400px] rounded-2xl overflow-hidden z-10" style="background: linear-gradient(180deg, #ffffff, #fafbfc);">
                <canvas id="mitraAvgChart"></canvas>
            </div>
        </div>
    </div>

    </div>

    <script>
        function initProgressChart() {
            if (typeof Chart === 'undefined') {
                const s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                s.setAttribute('data-chartjs', '1');
                s.onload = buildChart;
                document.head.appendChild(s);
            } else {
                buildChart();
            }
        }

        function buildChart() {
            // Destroy existing
            if (window._stackedChart instanceof Chart) {
                window._stackedChart.destroy();
            }
            if (window._ihldChart instanceof Chart) {
                window._ihldChart.destroy();
            }
            if (window._mitraAvgChart instanceof Chart) {
                window._mitraAvgChart.destroy();
            }

            const ctxStacked = document.getElementById('stackedChart');
            const ctxIhld = document.getElementById('ihldChart');
            const ctxMitraAvg = document.getElementById('mitraAvgChart');
            if (!ctxStacked || !ctxIhld) return;

            const datelLabels = @json($datelLabels);
            const stackedData = @json($stackedData);
            const mitraAvgTextLabels = @json($mitraAvgTextLabels ?? []);

            // Custom plugin to draw average labels on top of the bars
            const barLabelsPluginFilter = {
                id: 'barLabels',
                afterDraw: (chart) => {
                    if (chart.canvas.id !== 'mitraAvgChart') return;
                    const {
                        ctx,
                        data,
                        chartArea: {
                            top,
                            bottom,
                            left,
                            right
                        },
                        scales: {
                            x,
                            y
                        }
                    } = chart;
                    ctx.save();
                    data.datasets[0].data.forEach((value, index) => {
                        const label = mitraAvgTextLabels[index] || '';
                        const meta = chart.getDatasetMeta(0);
                        const bar = meta.data[index];
                        if (!bar) return;

                        ctx.font = 'bold 10px Inter, sans-serif';
                        ctx.fillStyle = '#db2777'; // Pink-600 logic
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        // Placement: slightly above the bar end
                        const posX = bar.x;
                        const posY = bar.y - 8;

                        // Only draw if within chart area
                        if (posY > top) {
                            ctx.fillText(label, posX, posY);
                        }
                    });
                    ctx.restore();
                }
            };

            // --- STACKED PROGRESS BREAKDOWN CHART ---
            const colorMap = {
                'ON DESK': {
                    bg: 'rgba(99,102,241,0.85)',
                    border: '#6366f1'
                },
                'SURVEY': {
                    bg: 'rgba(59,130,246,0.85)',
                    border: '#3b82f6'
                },
                'PERIJINAN': {
                    bg: 'rgba(14,165,233,0.85)',
                    border: '#0ea5e9'
                },
                'DRM': {
                    bg: 'rgba(20,184,166,0.85)',
                    border: '#14b8a6'
                },
                'APPROVED BY EBIS': {
                    bg: 'rgba(16,185,129,0.85)',
                    border: '#10b981'
                },
                'MATDEV': {
                    bg: 'rgba(34,197,94,0.85)',
                    border: '#22c55e'
                },
                'INSTALASI': {
                    bg: 'rgba(132,204,22,0.85)',
                    border: '#84cc16'
                },
                'SELESAI FISIK': {
                    bg: 'rgba(234,179,8,0.85)',
                    border: '#eab308'
                },
                'GOLIVE': {
                    bg: 'rgba(245,158,11,0.85)',
                    border: '#f59e0b'
                },
                'PS': {
                    bg: 'rgba(249,115,22,0.85)',
                    border: '#f97316'
                },
                'KENDALA': {
                    bg: 'rgba(239,68,68,0.85)',
                    border: '#ef4444'
                },
                'UJI TERIMA': {
                    bg: 'rgba(168,85,247,0.85)',
                    border: '#a855f7'
                },
                'REKON': {
                    bg: 'rgba(236,72,153,0.85)',
                    border: '#ec4899'
                },
            };

            const datasets = [];
            Object.keys(stackedData).forEach(stage => {
                // Check if there's at least one order in this stage across all datels to avoid empty legends
                const totalInStage = stackedData[stage].reduce((sum, val) => sum + val, 0);
                if (totalInStage > 0) {
                    const color = colorMap[stage] || {
                        bg: 'rgba(107,114,128,0.8)',
                        border: '#6b7280'
                    };
                    datasets.push({
                        label: stage,
                        data: stackedData[stage],
                        backgroundColor: color.bg,
                        borderColor: color.border,
                        borderWidth: 1,
                        _origBg: color.bg, // Save original color for hover effect
                        _origBorder: color.border,
                        borderRadius: {
                            topLeft: 4,
                            topRight: 4
                        },
                    });
                }
            });

            window._stackedChart = new Chart(ctxStacked.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: datelLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'x'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                },
                                padding: 20
                            },
                            onHover: function(e, legendItem, legend) {
                                const index = legendItem.datasetIndex;
                                const chart = legend.chart;
                                chart.data.datasets.forEach((dataset, i) => {
                                    if (i !== index) {
                                        dataset.backgroundColor =
                                        'rgba(226, 232, 240, 0.4)'; // slate-200 / redup
                                        dataset.borderColor =
                                        'rgba(203, 213, 225, 0.5)'; // slate-300 / redup
                                    } else {
                                        dataset.backgroundColor = dataset._origBg; // nyala
                                        dataset.borderColor = dataset._origBorder;
                                    }
                                });
                                chart.update();
                            },
                            onLeave: function(e, legendItem, legend) {
                                const chart = legend.chart;
                                chart.data.datasets.forEach((dataset) => {
                                    dataset.backgroundColor = dataset._origBg;
                                    dataset.borderColor = dataset._origBorder;
                                });
                                chart.update();
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1a1a2e',
                            titleFont: {
                                weight: 'bold',
                                size: 13
                            },
                            bodyFont: {
                                size: 12
                            },
                            cornerRadius: 12,
                            padding: 12,
                            callbacks: {
                                title: (items) => `Datel: ${items[0].label}`,
                                label: (c) => ` ${c.dataset.label}: ${c.parsed.y} Order`
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: false,
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: 'bold',
                                    size: 10
                                },
                                color: '#6b7280',
                                autoSkip: false,
                            }
                        },
                        y: {
                            stacked: false,
                            beginAtZero: true,
                            grace: '150%', // Tambahkan ruang ekstra di atas bar agar bar terlihat lebih pendek
                            grid: {
                                color: 'rgba(243, 244, 246, 1)',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    weight: 'bold',
                                    size: 11
                                },
                                color: '#9ca3af',
                                stepSize: 1,
                                precision: 0
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Order',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                color: '#6b7280'
                            }
                        }
                    },
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart'
                    }
                }
            });

            // --- iHLD STATUS ORDER CHART ---
            const ihldStatuses = @json($ihldStatuses);
            const ihldStackedData = @json($ihldStackedData);

            const ihldDatasets = [];
            const ihldColors = [{
                    bg: 'rgba(79,  70,  229, 0.85)',
                    border: '#4f46e5'
                }, // indigo
                {
                    bg: 'rgba(14,  165, 233, 0.85)',
                    border: '#0ea5e9'
                }, // sky
                {
                    bg: 'rgba(236, 72,  153, 0.85)',
                    border: '#ec4899'
                }, // pink
                {
                    bg: 'rgba(245, 158, 11,  0.85)',
                    border: '#f59e0b'
                }, // amber
                {
                    bg: 'rgba(16,  185, 129, 0.85)',
                    border: '#10b981'
                }, // emerald
                {
                    bg: 'rgba(139, 92,  246, 0.85)',
                    border: '#8b5cf6'
                }, // violet
                {
                    bg: 'rgba(239, 68,  68,  0.85)',
                    border: '#ef4444'
                }, // red
                {
                    bg: 'rgba(20,  184, 166, 0.85)',
                    border: '#14b8a6'
                }, // teal
                {
                    bg: 'rgba(249, 115, 22,  0.85)',
                    border: '#f97316'
                }, // orange
            ];

            ihldStatuses.forEach((status, index) => {
                if (ihldStackedData[status]) {
                    const color = ihldColors[index % ihldColors.length];
                    ihldDatasets.push({
                        label: status,
                        data: ihldStackedData[status],
                        backgroundColor: color.bg,
                        borderColor: color.border,
                        borderWidth: 1,
                        _origBg: color.bg,
                        _origBorder: color.border,
                        borderRadius: {
                            topLeft: 4,
                            topRight: 4
                        },
                    });
                }
            });

            window._ihldChart = new Chart(ctxIhld.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: datelLabels,
                    datasets: ihldDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'x'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                },
                                padding: 20
                            },
                            onHover: function(e, legendItem, legend) {
                                const index = legendItem.datasetIndex;
                                const chart = legend.chart;
                                chart.data.datasets.forEach((dataset, i) => {
                                    if (i !== index) {
                                        dataset.backgroundColor =
                                        'rgba(226, 232, 240, 0.4)'; // slate-200 / redup
                                        dataset.borderColor =
                                        'rgba(203, 213, 225, 0.5)'; // slate-300 / redup
                                    } else {
                                        dataset.backgroundColor = dataset._origBg; // nyala
                                        dataset.borderColor = dataset._origBorder;
                                    }
                                });
                                chart.update();
                            },
                            onLeave: function(e, legendItem, legend) {
                                const chart = legend.chart;
                                chart.data.datasets.forEach((dataset) => {
                                    dataset.backgroundColor = dataset._origBg;
                                    dataset.borderColor = dataset._origBorder;
                                });
                                chart.update();
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1a1a2e',
                            titleFont: {
                                weight: 'bold',
                                size: 13
                            },
                            bodyFont: {
                                size: 12
                            },
                            cornerRadius: 12,
                            padding: 12,
                            callbacks: {
                                title: (items) => `Datel: ${items[0].label}`,
                                label: (c) => ` ${c.dataset.label}: ${c.parsed.y} Order`
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: false,
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: 'bold',
                                    size: 10
                                },
                                color: '#6b7280',
                                autoSkip: false
                            }
                        },
                        y: {
                            stacked: false,
                            beginAtZero: true,
                            grace: '150%',
                            grid: {
                                color: 'rgba(243, 244, 246, 1)',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    weight: 'bold',
                                    size: 11
                                },
                                color: '#9ca3af',
                                stepSize: 1,
                                precision: 0
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Order',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                color: '#6b7280'
                            }
                        }
                    },
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart'
                    }
                }
            });

            // --- MITRA AVG DURATION CHART ---
            const mitraAvgLabels = @json($mitraAvgLabels ?? []);
            const mitraAvgValues = @json($mitraAvgValues ?? []);

            if (ctxMitraAvg && mitraAvgLabels.length > 0) {
                // Create gradient for each bar
                const ctx = ctxMitraAvg.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(220, 38, 38, 0.9)');
                gradient.addColorStop(0.5, 'rgba(220, 38, 38, 0.7)');
                gradient.addColorStop(1, 'rgba(220, 38, 38, 0.4)');

                // Create hover gradient
                const hoverGradient = ctx.createLinearGradient(0, 0, 0, 400);
                hoverGradient.addColorStop(0, 'rgba(185, 28, 28, 0.95)');
                hoverGradient.addColorStop(0.5, 'rgba(185, 28, 28, 0.75)');
                hoverGradient.addColorStop(1, 'rgba(185, 28, 28, 0.5)');

                window._mitraAvgChart = new Chart(ctxMitraAvg.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: mitraAvgLabels,
                        datasets: [{
                            label: 'Rata-rata Hari',
                            data: mitraAvgValues,
                            backgroundColor: gradient,
                            hoverBackgroundColor: hoverGradient,
                            borderColor: 'rgba(220, 38, 38, 0.3)',
                            hoverBorderColor: 'rgba(185, 28, 28, 0.5)',
                            borderWidth: 2,
                            borderRadius: {
                                topLeft: 12,
                                topRight: 12,
                                bottomLeft: 4,
                                bottomRight: 4
                            },
                            borderSkipped: false,
                            barPercentage: 0.65,
                            categoryPercentage: 0.8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'x',
                        layout: {
                            padding: {
                                top: 50,
                                left: 10,
                                right: 10
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(26, 26, 46, 0.95)',
                                titleFont: {
                                    weight: 'bold',
                                    size: 13
                                },
                                bodyFont: {
                                    size: 12
                                },
                                cornerRadius: 12,
                                padding: 14,
                                displayColors: false,
                                boxPadding: 6,
                                callbacks: {
                                    label: function(context) {
                                        const index = context.dataIndex;
                                        const fullLabel = mitraAvgTextLabels[index] || '';
                                        return ` Rata-rata: ${fullLabel}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        weight: '600',
                                        size: 10
                                    },
                                    color: '#64748b',
                                    autoSkip: false,
                                    maxRotation: 45,
                                    minRotation: 45,
                                    padding: 8
                                },
                                border: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grace: '25%',
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.6)',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        weight: '600',
                                        size: 11
                                    },
                                    color: '#94a3b8',
                                    padding: 10
                                },
                                title: {
                                    display: true,
                                    text: 'Hari',
                                    font: {
                                        weight: 'bold',
                                        size: 11
                                    },
                                    color: '#64748b',
                                    padding: { top: 0, bottom: 10 }
                                },
                                border: {
                                    display: false
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart',
                            delay: (context) => {
                                return context.dataIndex * 150;
                            }
                        },
                        hover: {
                            mode: 'index',
                            intersect: false
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    plugins: [barLabelsPluginFilter]
                });
            }
        }

        // ======= MULTI-SELECT DROPDOWN LOGIC =======
        function toggleMultiSelect(type) {
            const dropdown = document.getElementById(type + '-dropdown');
            const chevron = document.getElementById(type + '-chevron');
            const isHidden = dropdown.classList.contains('hidden');

            // Close all other dropdowns first
            ['sto', 'datel', 'mitra'].forEach(t => {
                if (t !== type) {
                    document.getElementById(t + '-dropdown')?.classList.add('hidden');
                    document.getElementById(t + '-chevron')?.style.removeProperty('transform');
                }
            });

            if (isHidden) {
                dropdown.classList.remove('hidden');
                chevron.style.transform = 'rotate(180deg)';
            } else {
                dropdown.classList.add('hidden');
                chevron.style.removeProperty('transform');
            }
        }

        function updateMultiLabel(type) {
            const checkboxes = document.querySelectorAll('#' + type + '-options input[type="checkbox"]:checked');
            const label = document.getElementById(type + '-label');
            const count = checkboxes.length;
            const typeNames = {
                sto: 'STO',
                datel: 'Datel',
                mitra: 'Mitra'
            };
            const typeName = typeNames[type] || type;

            if (count === 0) {
                label.textContent = 'Semua ' + typeName;
            } else {
                label.textContent = count + ' ' + typeName + ' dipilih';
            }
        }

        function filterOptions(type, query) {
            const options = document.querySelectorAll('.' + type + '-option');
            const q = query.toLowerCase();
            options.forEach(opt => {
                const val = opt.getAttribute('data-value') || '';
                opt.style.display = val.includes(q) ? '' : 'none';
            });
        }

        // Close dropdowns on click outside
        document.addEventListener('click', function(e) {
            ['sto', 'datel', 'mitra'].forEach(type => {
                const container = document.getElementById(type + '-multiselect');
                const dropdown = document.getElementById(type + '-dropdown');
                const chevron = document.getElementById(type + '-chevron');
                if (container && !container.contains(e.target)) {
                    dropdown?.classList.add('hidden');
                    if (chevron) chevron.style.removeProperty('transform');
                }
            });
        });

        // Clock — sama persis dengan Admin Dashboard
        function updateProgressClock() {
            const now = new Date();
            const dateEl = document.getElementById('live-date');
            const timeEl = document.getElementById('live-clock');
            if (!dateEl || !timeEl) return;

            const hours   = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            timeEl.textContent = `${hours}:${minutes}:${seconds}`;

            const days   = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            dateEl.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
        }

        // Bootstrap chart
        document.addEventListener('turbo:load', initProgressChart);
        document.addEventListener('DOMContentLoaded', initProgressChart);

        // Start clock — update setiap 1 detik seperti dashboard admin
        if (window._progressClockInterval) clearInterval(window._progressClockInterval);
        updateProgressClock();
        window._progressClockInterval = setInterval(updateProgressClock, 1000);

        // Cleanup for Turbo
        document.addEventListener('turbo:before-cache', function() {
            if (window._stackedChart instanceof Chart) {
                window._stackedChart.destroy();
            }
            if (window._ihldChart instanceof Chart) {
                window._ihldChart.destroy();
            }
            if (window._mitraAvgChart instanceof Chart) {
                window._mitraAvgChart.destroy();
            }
            if (window._progressClockInterval) {
                clearInterval(window._progressClockInterval);
                window._progressClockInterval = null;
            }
        });
    </script>
@endsection
