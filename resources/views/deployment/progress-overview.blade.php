@extends('layouts.app')

@section('title', 'Progress Overview')

@section('content')
    <div class="flex flex-col gap-6">

        
        <div class="flex items-center gap-3 text-sm text-slate-500">
            <a href="{{ route('dashboard') }}" class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
            <span class="text-slate-300 font-bold">❯</span>
            <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">Progress Overview</span>
        </div>



        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            
            <a href="{{ route('deployment.update') }}"
                class="bg-white rounded-2xl p-5 shadow-sm border relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 block"
                style="border-color:#fde8e8; box-shadow: 0 4px 20px rgba(227,43,43,0.06);">
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

            
            <a href="{{ route('deployment.update', ['filter_key' => 'progres', 'filter_values' => 'ON DESK,SURVEY,PERIJINAN,DRM,APPROVED BY EBIS,MATDEV,INSTALASI,SELESAI FISIK']) }}"
                class="bg-white rounded-2xl p-5 shadow-sm border relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 block"
                style="border-color:#d1fae5; box-shadow: 0 4px 20px rgba(16,185,129,0.06);">
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
                    <p class="text-3xl font-black tracking-tight" style="color:#065f46;">{{ number_format($totalOnTrack) }}</p>
                    <p class="text-[10px] font-bold mt-1" style="color:#9ca3af;">Berjalan Normal</p>
                </div>
            </a>

            
            <a href="{{ route('deployment.update', ['filter_key' => 'progres', 'filter_values' => 'GOLIVE,PS,UJI TERIMA,REKON']) }}"
                class="bg-white rounded-2xl p-5 shadow-sm border relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 block"
                style="border-color:#dbeafe; box-shadow: 0 4px 20px rgba(59,130,246,0.06);">
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
                    <p class="text-3xl font-black tracking-tight" style="color:#1e40af;">{{ number_format($totalSelesai) }}</p>
                    <p class="text-[10px] font-bold mt-1" style="color:#9ca3af;">Tahap Akhir & Done</p>
                </div>
            </a>

            
            <a href="{{ route('deployment.update', ['usia' => 'overdue']) }}"
                class="bg-white rounded-2xl p-5 shadow-sm border relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 block"
                style="border-color:#fee2e2; box-shadow: 0 4px 20px rgba(239,68,68,0.06);">
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
                        <span class="text-[10px] font-bold uppercase tracking-widest" style="color:#9ca3af;">OVERDUE</span>
                    </div>
                    <p class="text-3xl font-black tracking-tight" style="color:#991b1b;">{{ number_format($totalOverdue) }}</p>
                    <p class="text-[10px] font-bold mt-1" style="color:#9ca3af;">Melewati Commitment Date</p>
                </div>
            </a>

        </div>

        
        <div class="bg-white rounded-[2rem] shadow-xl border" style="border-color:#fde8e8; box-shadow: 0 20px 40px rgba(227,43,43,0.06);">

            
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-6 sm:px-8 pt-6 sm:pt-8 pb-0">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-2xl" style="background:#fef2f2; color:#e32b2b;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold tracking-tight" style="color:#1a1a2e;">Visualisasi Timeline Progres</h3>
                        <p class="text-[10px] font-bold uppercase tracking-widest mt-0.5" style="color:#9ca3af;">Perbandingan durasi pengerjaan antar-tahap progres secara visual</p>
                    </div>
                </div>
            </div>

            
            <form method="GET" action="{{ route('deployment.progress-overview') }}" id="filterForm" class="px-6 sm:px-8 pt-5 pb-0">

                
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 p-4 rounded-2xl border bg-slate-50 border-slate-100">

                    
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1 text-slate-400">Tahun</label>
                        <select name="year" onchange="this.form.requestSubmit()"
                            class="w-full rounded-xl border-slate-200 bg-white text-xs font-semibold py-2 px-3 focus:ring-red-500 focus:border-red-500 transition">
                            @for ($y = date('Y'); $y >= date('Y') - 3; $y--)
                                <option value="{{ $y }}" {{ ($filterYear ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1 text-slate-400">Bulan</label>
                        <select name="month" onchange="this.form.requestSubmit()"
                            class="w-full rounded-xl border-slate-200 bg-white text-xs font-semibold py-2 px-3 focus:ring-red-500 focus:border-red-500 transition">
                            <option value="all">Semua Bulan</option>
                            @foreach ([1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'] as $num => $name)
                                <option value="{{ $num }}" {{ ($filterMonth ?? '') == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1 text-slate-400">Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from"
                            value="{{ request('date_from') }}"
                            onchange="this.form.requestSubmit()"
                            class="w-full rounded-xl border-slate-200 bg-white text-xs font-semibold py-2 px-3 focus:ring-red-500 focus:border-red-500 transition">
                    </div>

                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1 text-slate-400">Sampai Tanggal</label>
                        <input type="date" name="date_to" id="date_to"
                            value="{{ request('date_to') }}"
                            onchange="this.form.requestSubmit()"
                            class="w-full rounded-xl border-slate-200 bg-white text-xs font-semibold py-2 px-3 focus:ring-red-500 focus:border-red-500 transition">
                    </div>

                    
                    <div class="relative" id="mitra-multiselect">
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1 text-slate-400">Mitra</label>
                        <button type="button" onclick="toggleMultiSelect('mitra')"
                            class="w-full rounded-xl border border-slate-200 bg-white text-xs font-semibold py-2 px-3 text-left flex items-center justify-between transition hover:border-red-300">
                            <span id="mitra-label" class="truncate">
                                @if (!empty($filterMitraArr)) {{ count($filterMitraArr) }} Mitra dipilih
                                @else Semua Mitra
                                @endif
                            </span>
                            <svg class="w-4 h-4 shrink-0 ml-2 text-slate-400" id="mitra-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="mitra-dropdown" class="hidden absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-xl max-h-52 overflow-y-auto" style="min-width:200px;">
                            <div class="p-2 border-b border-slate-100">
                                <input type="text" placeholder="Cari Mitra..." oninput="filterOptions('mitra', this.value)"
                                    class="w-full rounded-lg border-slate-200 text-xs py-1.5 px-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div id="mitra-options" class="p-1">
                                @foreach ($mitraList as $mitra)
                                    <label class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-red-50 cursor-pointer text-xs font-semibold mitra-option" data-value="{{ strtolower($mitra) }}">
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

                </div>

                  @if (!empty($timelineData))
                
                <div class="mx-6 sm:mx-8 border-t border-slate-100"></div>

                
                <div class="px-6 sm:px-8 pb-6 sm:pb-8 pt-6">

                <div class="space-y-8">
                    @foreach ($timelineData as $mitraTimeline)
                        <div class="space-y-4">
                            
                            <div class="flex items-center gap-3">
                                <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase bg-red-600 text-white tracking-widest shadow-md">
                                    Mitra: {{ $mitraTimeline['mitra'] }}
                                </span>
                                <div class="flex-1 h-px bg-slate-100"></div>
                                <span class="text-xs font-bold text-slate-400">{{ $mitraTimeline['total_orders'] }} Total Order</span>
                            </div>

                            <div class="space-y-6 pl-4 border-l-2 border-slate-100">
                                <div class="border border-slate-100 rounded-3xl shadow-sm p-6 bg-white hover:shadow-md transition relative">

                                    
                                    <div class="overflow-x-auto pb-2" style="scrollbar-width:thin; scrollbar-color:#e2e8f0 transparent;">
                                        <div class="relative flex min-w-max" style="padding: 0 24px;">
                                            <div class="absolute left-0 right-0" style="top: 140px; height: 2px; border-top: 2px dotted #cbd5e1; z-index: 0;"></div>

                                            {{-- Connector labels between nodes --}}
                                            @foreach ($mitraTimeline['steps'] as $idx => $s)
                                                @if ($idx > 0)
                                                    @php
                                                        $prevStage = $mitraTimeline['steps'][$idx - 1]['stage'];
                                                        $currStage = $s['stage'];
                                                        // midpoint between two nodes: 24px padding + node center offset
                                                        $leftPos   = 24 + $idx * 220;
                                                    @endphp
                                                    <div style="position:absolute; top:82px; left:{{ $leftPos }}px; transform:translateX(-50%); z-index:15; white-space:nowrap; display:flex; flex-direction:column; align-items:center; gap:3px;">
                                                        <span style="display:inline-flex; align-items:center; gap:3px; font-size:8px; font-weight:800; color:#6366f1; background:#eef2ff; border:1px solid #c7d2fe; border-radius:999px; padding:2px 8px; letter-spacing:0.05em; text-transform:uppercase; box-shadow:0 1px 4px rgba(99,102,241,0.12);">
                                                            {{ $prevStage }} &#8594; {{ $currStage }}
                                                        </span>
                                                        @if ($s['duration'] !== 'N/A')
                                                        <span style="font-size:9px; font-weight:900; color:#4f46e5; letter-spacing:0.03em; text-transform:uppercase;">
                                                            {{ $s['duration'] }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach

                                            @foreach ($mitraTimeline['steps'] as $index => $step)
                                                @php
                                                    $stageColors = [
                                                        'ON DESK'          => ['badge_bg' => '#e0e7ff', 'badge_text' => '#3730a3', 'node_bg' => '#6366f1', 'node_ring' => '#c7d2fe', 'connector' => '#6366f1'],
                                                        'SURVEY'           => ['badge_bg' => '#dbeafe', 'badge_text' => '#1d4ed8', 'node_bg' => '#3b82f6', 'node_ring' => '#bfdbfe', 'connector' => '#3b82f6'],
                                                        'PERIJINAN'        => ['badge_bg' => '#e0f2fe', 'badge_text' => '#0369a1', 'node_bg' => '#0ea5e9', 'node_ring' => '#bae6fd', 'connector' => '#0ea5e9'],
                                                        'DRM'              => ['badge_bg' => '#ccfbf1', 'badge_text' => '#0f766e', 'node_bg' => '#14b8a6', 'node_ring' => '#99f6e4', 'connector' => '#14b8a6'],
                                                        'APPROVED BY EBIS' => ['badge_bg' => '#d1fae5', 'badge_text' => '#065f46', 'node_bg' => '#10b981', 'node_ring' => '#a7f3d0', 'connector' => '#10b981'],
                                                        'MATDEV'           => ['badge_bg' => '#dcfce7', 'badge_text' => '#166534', 'node_bg' => '#22c55e', 'node_ring' => '#bbf7d0', 'connector' => '#22c55e'],
                                                        'INSTALASI'        => ['badge_bg' => '#ecfccb', 'badge_text' => '#3f6212', 'node_bg' => '#84cc16', 'node_ring' => '#d9f99d', 'connector' => '#84cc16'],
                                                        'SELESAI FISIK'    => ['badge_bg' => '#fef9c3', 'badge_text' => '#854d0e', 'node_bg' => '#eab308', 'node_ring' => '#fde68a', 'connector' => '#eab308'],
                                                        'GOLIVE'           => ['badge_bg' => '#fef3c7', 'badge_text' => '#92400e', 'node_bg' => '#f59e0b', 'node_ring' => '#fde68a', 'connector' => '#f59e0b'],
                                                        'PS'               => ['badge_bg' => '#ffedd5', 'badge_text' => '#9a3412', 'node_bg' => '#f97316', 'node_ring' => '#fed7aa', 'connector' => '#f97316'],
                                                        'KENDALA'          => ['badge_bg' => '#fee2e2', 'badge_text' => '#991b1b', 'node_bg' => '#ef4444', 'node_ring' => '#fecaca', 'connector' => '#ef4444'],
                                                        'UJI TERIMA'       => ['badge_bg' => '#f3e8ff', 'badge_text' => '#6b21a8', 'node_bg' => '#a855f7', 'node_ring' => '#e9d5ff', 'connector' => '#a855f7'],
                                                        'REKON'            => ['badge_bg' => '#fce7f3', 'badge_text' => '#9d174d', 'node_bg' => '#ec4899', 'node_ring' => '#fbcfe8', 'connector' => '#ec4899'],
                                                    ];
                                                    $col = $stageColors[$step['stage']] ?? ['badge_bg' => '#f1f5f9', 'badge_text' => '#475569', 'node_bg' => '#94a3b8', 'node_ring' => '#e2e8f0', 'connector' => '#94a3b8'];
                                                    $isTop = ($index % 2 === 0);
                                                @endphp

                                                <div class="relative flex flex-col items-center shrink-0" style="width:220px; z-index:10;">

                                                    
                                                    <div style="height:112px; display:flex; flex-direction:column; align-items:center; justify-content:flex-end;">
                                                        @if ($isTop)
                                                            <div style="display:flex; flex-direction:column; align-items:center; text-align:center; max-width:200px;">
                                                                <span style="font-size:10px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; line-height:1.3; max-width:180px;">{{ $step['stage'] }}</span>
                                                                <span style="font-size:8px; font-weight:700; color:#94a3b8; font-family:monospace; margin-top:3px;">{{ $step['time'] }}</span>
                                                            </div>
                                                            <div style="width:1px; height:28px; border-left:2px dotted {{ $col['connector'] }}; margin-top:6px; opacity:0.5;"></div>
                                                        @else
                                                            <div style="height:112px;"></div>
                                                        @endif
                                                    </div>

                                                    
                                                    <div style="height:56px; display:flex; align-items:center; justify-content:center; position:relative; z-index:20;">
                                                        <div style="width:18px; height:18px; border-radius:50%; background:{{ $col['node_bg'] }}; border:3px solid white; box-shadow:0 0 0 3px {{ $col['node_ring'] }}, 0 2px 8px rgba(0,0,0,0.12);"></div>
                                                    </div>

                                                    
                                                    <div style="height:112px; display:flex; flex-direction:column; align-items:center; justify-content:flex-start;">
                                                        @if (!$isTop)
                                                            <div style="width:1px; height:28px; border-left:2px dotted {{ $col['connector'] }}; margin-bottom:6px; opacity:0.5;"></div>
                                                            <div style="display:flex; flex-direction:column; align-items:center; text-align:center; max-width:200px;">
                                                                <span style="font-size:10px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.04em; line-height:1.3; max-width:180px;">{{ $step['stage'] }}</span>
                                                                <span style="font-size:8px; font-weight:700; color:#94a3b8; font-family:monospace; margin-top:3px;">{{ $step['time'] }}</span>
                                                            </div>
                                                        @else
                                                            <div style="height:112px;"></div>
                                                        @endif
                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                </div>
            @endif
        </div>


        
        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl border mt-6"
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

        
        <div class="bg-white rounded-[2.5rem] p-6 sm:p-8 shadow-xl border mt-6 relative overflow-hidden"
            style="border-color:#fde8e8; box-shadow: 0 20px 50px rgba(227,43,43,0.08);">
            
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

            
            <div class="relative w-full h-[400px] rounded-2xl overflow-hidden z-10" style="background: linear-gradient(180deg, #ffffff, #fafbfc);">
                <canvas id="mitraAvgChart"></canvas>
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
                        const avgLabel = mitraAvgTextLabels[index] || '';
                        const detail = mitraAvgDetails[index];
                        const meta = chart.getDatasetMeta(0);
                        const bar = meta.data[index];
                        if (!bar) return;

                        // Draw average label
                        ctx.font = 'bold 10px Inter, sans-serif';
                        ctx.fillStyle = '#db2777'; // Pink-600 logic
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        // Placement: slightly above the bar end
                        const posX = bar.x;
                        const posY = bar.y - 20;

                        // Only draw if within chart area
                        if (posY > top) {
                            ctx.fillText(avgLabel, posX, posY);

                            // Draw order count below average label
                            if (detail && detail.count) {
                                ctx.font = '9px Inter, sans-serif';
                                ctx.fillStyle = '#64748b'; // Slate-500
                                ctx.fillText(`${detail.count} order`, posX, posY + 12);
                            }
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
            const mitraAvgDetails = @json($mitraAvgArray ?? []);

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
                                    title: function(context) {
                                        const index = context[0].dataIndex;
                                        const detail = mitraAvgDetails[index];
                                        return detail ? detail.mitra : '';
                                    },
                                    label: function(context) {
                                        const index = context.dataIndex;
                                        const detail = mitraAvgDetails[index];
                                        if (!detail) return '';

                                        const lines = [
                                            `Rata-rata: ${detail.avg_label}`,
                                            `Jumlah Order: ${detail.count} order`,
                                            `Total Durasi: ${detail.total_label}`
                                        ];
                                        return lines;
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
        function getCheckboxesState(type) {
            const checked = [];
            document.querySelectorAll('#' + type + '-options input[type="checkbox"]:checked').forEach(cb => {
                checked.push(cb.value);
            });
            return checked.sort().join(',');
        }

        function triggerFormSubmit() {
            document.getElementById('filterForm')?.requestSubmit();
        }

        function toggleMultiSelect(type) {
            const dropdown = document.getElementById(type + '-dropdown');
            const chevron = document.getElementById(type + '-chevron');
            if (!dropdown) return;
            const isHidden = dropdown.classList.contains('hidden');

            let submitNeeded = false;

            // Close all other dropdowns first
            ['sto', 'datel', 'mitra'].forEach(t => {
                if (t !== type) {
                    const otherDropdown = document.getElementById(t + '-dropdown');
                    if (otherDropdown && !otherDropdown.classList.contains('hidden')) {
                        otherDropdown.classList.add('hidden');
                        document.getElementById(t + '-chevron')?.style.removeProperty('transform');
                        if (otherDropdown.dataset.initialState !== getCheckboxesState(t)) {
                            submitNeeded = true;
                        }
                    }
                }
            });

            if (isHidden) {
                dropdown.classList.remove('hidden');
                if (chevron) chevron.style.transform = 'rotate(180deg)';
                dropdown.dataset.initialState = getCheckboxesState(type);
            } else {
                dropdown.classList.add('hidden');
                if (chevron) chevron.style.removeProperty('transform');
                if (dropdown.dataset.initialState !== getCheckboxesState(type)) {
                    submitNeeded = true;
                }
            }

            if (submitNeeded) {
                triggerFormSubmit();
            }
        }

        function updateMultiLabel(type) {
            const checkboxes = document.querySelectorAll('#' + type + '-options input[type="checkbox"]:checked');
            const label = document.getElementById(type + '-label');
            if (!label) return;
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
            let submitNeeded = false;
            ['sto', 'datel', 'mitra'].forEach(type => {
                const container = document.getElementById(type + '-multiselect');
                const dropdown = document.getElementById(type + '-dropdown');
                const chevron = document.getElementById(type + '-chevron');
                if (container && !container.contains(e.target)) {
                    if (dropdown && !dropdown.classList.contains('hidden')) {
                        dropdown.classList.add('hidden');
                        if (chevron) chevron.style.removeProperty('transform');
                        if (dropdown.dataset.initialState !== getCheckboxesState(type)) {
                            submitNeeded = true;
                        }
                    }
                }
            });
            if (submitNeeded) {
                triggerFormSubmit();
            }
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
