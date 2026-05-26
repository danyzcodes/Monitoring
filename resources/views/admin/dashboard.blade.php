@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="flex flex-col gap-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4" x-data="{
            showTeleModal: false,
            isSendingReport: false,
            toast: {
                show: false,
                message: '',
                type: 'success'
            },
            showToast(message, type = 'success') {
                this.toast.message = message;
                this.toast.type = type;
                this.toast.show = true;
                setTimeout(() => {
                    this.toast.show = false;
                }, 3000);
            },
            sendDailyReport() {
                const form = document.getElementById('dailyReportForm');
                const formData = new FormData(form);

                this.isSendingReport = true;

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.isSendingReport = false;
                    this.showTeleModal = false;
                    this.showToast(data.message, data.success ? 'success' : 'error');
                })
                .catch(error => {
                    this.isSendingReport = false;
                    this.showToast('Gagal mengirim laporan. Silakan coba lagi.', 'error');
                    console.error('Error:', error);
                });
            }
        }">
            <div class="flex items-center gap-3 text-sm text-slate-500">
                <a href="{{ route('dashboard') }}"
                    class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
                <span class="text-slate-300 font-bold">❯</span>
                <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">Live monitoring</span>
            </div>

            <div class="flex items-center gap-3">
                <button @click="showTeleModal = true"
                    class="group relative overflow-hidden flex items-center gap-2.5 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest text-white transition-all duration-300 shadow-xl shadow-red-200 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-red-300 active:scale-95"
                    style="background: linear-gradient(135deg, #e32b2b 0%, #ba1c1c 100%);">
                    
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                    </div>
                    <svg class="w-4 h-4 relative z-10 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    <span class="relative z-10">Kirim Laporan</span>
                </button>
            </div>

            
            <template x-teleport="body">
                <div x-show="showTeleModal"
                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

                    <div @click.outside="showTeleModal = false"
                        class="w-full max-w-sm bg-white rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden transform transition-all"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-90 translate-y-4">

                        <div class="p-8 text-center">
                            <div
                                class="w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-red-600 shadow-inner">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight mb-2">Kirim Laporan Harian?</h3>
                            <p class="text-sm text-slate-500 leading-relaxed mb-8">
                                Rekap seluruh progress hari ini akan dikirimkan langsung ke channel Telegram. Lanjutkan?
                            </p>

                            <div class="flex flex-col gap-3">
                                <form id="dailyReportForm" action="{{ route('admin.telegram.daily-report') }}" method="POST" @submit.prevent="sendDailyReport">
                                    @csrf
                                    <button type="submit"
                                        :disabled="isSendingReport"
                                        class="w-full py-3.5 rounded-2xl text-sm font-bold text-white shadow-xl shadow-red-200 transition active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                        style="background: linear-gradient(135deg, #e32b2b 0%, #991b1b 100%);">
                                        <span x-text="isSendingReport ? 'Mengirim...' : 'Ya, Kirim Sekarang'"></span>
                                    </button>
                                </form>
                                <button @click="showTeleModal = false"
                                    :disabled="isSendingReport"
                                    class="w-full py-4 rounded-2xl text-sm font-bold text-slate-400 hover:text-slate-600 transition active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Batalkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            
        <div x-show="toast.show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full"
             class="fixed top-4 right-4 z-50 flex items-center gap-3 px-6 py-4 rounded-2xl shadow-2xl"
             :class="toast.type === 'success' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'"
             style="display: none;">
            <div class="flex-shrink-0"
                 :class="toast.type === 'success' ? 'text-green-600' : 'text-red-600'">
                <svg x-show="toast.type === 'success'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <svg x-show="toast.type === 'error'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold"
                   :class="toast.type === 'success' ? 'text-green-800' : 'text-red-800'"
                   x-text="toast.message"></p>
            </div>
            <button @click="toast.show = false"
                    class="flex-shrink-0 p-1 rounded-lg hover:bg-opacity-80"
                    :class="toast.type === 'success' ? 'text-green-600 hover:bg-green-200' : 'text-red-600 hover:bg-red-200'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        </div>

        
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-6 relative overflow-hidden"
            style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%); border-radius: 2rem;">
            
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
                    <span class="text-[10px] font-black uppercase tracking-[0.25em]" style="color:#fca5a5;">Live Monitoring</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">Monitoring Progress Deployment</h1>
                
            </div>

            
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

        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            
            <div class="rounded-[2.5rem] p-8 text-white relative overflow-hidden group shadow-2xl flex flex-col min-h-[300px] transition-all duration-300 hover:-translate-y-1"
                style="background: linear-gradient(135deg, #1e3a8a 0%, #172554 100%); box-shadow: 0 20px 40px rgba(30,58,138,0.25);">
                
                <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full group-hover:scale-110 transition-transform duration-700"
                    style="background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);"></div>
                <div class="absolute top-0 right-0 w-32 h-32 rounded-bl-full group-hover:scale-110 transition-transform duration-500"
                    style="background:rgba(255,255,255,0.05);"></div>
                <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full"
                    style="background:rgba(255,255,255,0.05);"></div>

                <div class="relative z-10 flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-xl bg-white/10 text-white backdrop-blur-sm border border-white/20 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-extrabold tracking-tight">Confirm Users</h3>
                    </div>
                    <span id="waitingApprovalBadge"
                        class="text-white text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-widest backdrop-blur-sm border border-white/20"
                        style="background:rgba(255,255,255,0.1);">
                        Action Required
                    </span>
                </div>

                <div id="waitingUsersContainer"
                    class="relative z-10 space-y-4 flex-1 overflow-y-auto no-scrollbar">
                    @forelse($waitingUsers as $user)
                        <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/10 transition-colors border backdrop-blur-sm"
                            style="background:rgba(255,255,255,0.05); border-color:rgba(255,255,255,0.1);">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-black text-xs uppercase shadow-sm text-blue-900 bg-white">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold leading-none">{{ $user->name }}</p>
                                    @if ($user->requested_role)
                                        <span class="inline-block mt-1 text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md text-blue-100 bg-white/20">
                                            Req: {{ ucfirst($user->requested_role) }}
                                        </span>
                                    @endif
                                    <p class="text-[10px] mt-0.5 text-blue-200">
                                        {{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.users') }}"
                                class="p-2 rounded-xl border border-white/20 hover:bg-white hover:text-blue-900 hover:scale-105 transition-all text-white backdrop-blur-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full py-10 opacity-70">
                            <svg class="w-10 h-10 mx-auto mb-2 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-[10px] font-extrabold uppercase tracking-widest text-white/70">Belum ada user</p>
                        </div>
                    @endforelse
                </div>
            </div>

            
            <div class="rounded-[2.5rem] p-8 text-white relative overflow-hidden group shadow-2xl flex flex-col min-h-[300px]"
                style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);">
                
                <div class="absolute -top-24 -right-24 w-64 h-64 rounded-full blur-[80px] opacity-40 group-hover:scale-110 transition-transform duration-700"
                    style="background:#e32b2b;"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 rounded-full blur-[80px] opacity-20 group-hover:scale-110 transition-transform duration-700"
                    style="background:#ff6b6b;"></div>

                <div class="relative z-10 flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-xl" style="background:rgba(227,43,43,0.25);">
                            <svg class="w-5 h-5" style="color:#fca5a5;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase tracking-[0.2em]" style="color:#fca5a5;">Overdue
                                Commitments</label>
                            <p class="text-[10px] mt-0.5" style="color:#6b7280;">Tanggal komitmen yang sudah terlewat</p>
                        </div>
                    </div>
                    <span class="text-xs font-black px-3 py-1 rounded-xl"
                        style="background:rgba(227,43,43,0.3); color:#fca5a5;">
                        {{ $overdueCommitments->count() }} item
                    </span>
                </div>

                <div class="relative z-10 flex-1 overflow-y-auto no-scrollbar space-y-3 max-h-[200px]">
                    @forelse($overdueCommitments as $item)
                        <a href="{{ route('deployment.edit', $item['id']) }}"
                            class="block p-3 rounded-2xl hover:bg-white/10 transition-colors cursor-pointer"
                            style="background:rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.07);">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-black text-white truncate">#{{ $item['star_click_id'] }}</p>
                                    <p class="text-[10px] truncate mt-0.5" style="color:#9ca3af;">
                                        {{ $item['nama_customer'] }}</p>
                                </div>
                                
                                <span class="flex-shrink-0 text-[9px] font-black px-2 py-1 rounded-lg whitespace-nowrap"
                                    style="background:rgba(227,43,43,0.4); color:#fca5a5;">
                                    terlewat {{ $item['days_overdue'] }} hari
                                </span>
                            </div>
                            <div class="flex items-center gap-1 mt-1.5" style="color:#6b7280;">
                                <svg class="w-2.5 h-2.5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <p class="text-[9px] truncate">{{ $item['updated_by'] }} &bull;
                                    {{ \Carbon\Carbon::parse($item['commitment_date'])->format('d M Y') }}</p>
                                <span class="ml-auto flex-shrink-0 text-[8px] font-bold px-1.5 py-0.5 rounded"
                                    style="background:rgba(255,255,255,0.08); color:#9ca3af;">{{ $item['status'] }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 opacity-30">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs font-bold uppercase tracking-widest">Semua On Track!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            
            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl border flex flex-col relative overflow-hidden group min-h-[300px] transition-all duration-300 hover:-translate-y-1"
                style="border-color:#fde8e8; box-shadow: 0 20px 40px rgba(227,43,43,0.08);">
                <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full blur-3xl transition-colors duration-700"
                    style="background:rgba(227,43,43,0.06);"></div>

                <div class="flex items-center justify-between mb-6 relative">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-xl animate-pulse" style="background:#fef2f2; color:#e32b2b;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 class="text-sm font-black uppercase tracking-widest" style="color:#1a1a2e;">Live Tracking</h4>
                    </div>
                    <div class="text-[10px] font-bold px-2 py-1 rounded-lg" id="liveTrackingCount"
                        style="color:#e32b2b; background:#fef2f2;">{{ $liveTracking->count() }} Updates</div>
                </div>

                <div class="flex-1 overflow-y-auto no-scrollbar space-y-4 max-h-[160px]" id="liveTrackingContainer">
                    @forelse($liveTracking as $log)
                        <div
                            class="flex items-start gap-3 p-3 rounded-2xl hover:bg-red-50 transition-colors border border-transparent hover:border-red-100">
                            <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold border-2 border-white shadow-sm"
                                style="background:#fef2f2; color:#e32b2b;">
                                {{ strtoupper(substr($log->user->name ?? '?', 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-0.5">
                                    <p class="text-[11px] font-black truncate" style="color:#1a1a2e;">
                                        {{ $log->user->name ?? 'System' }}</p>
                                    <p class="text-[9px] font-bold" style="color:#9ca3af;">
                                        {{ $log->created_at->diffForHumans(null, true, true) }}</p>
                                </div>
                                <p class="text-[10px] font-medium" style="color:#6b7280;">Updated <span
                                        class="font-bold tracking-tight"
                                        style="color:#e32b2b;">#{{ $log->planning->star_click_id ?? 'N/A' }}</span></p>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="text-[8px] font-black uppercase tracking-tighter px-1.5 py-0.5 rounded-md"
                                        style="background:#fef2f2; color:#e32b2b;">
                                        {{ $log->progres }}
                                    </span>
                                    @if ($log->data && isset($log->data['commitment_date']))
                                        <span
                                            class="text-[8px] font-black uppercase tracking-tighter px-1.5 py-0.5 rounded-md flex items-center gap-1"
                                            style="background:#fffbeb; color:#d97706;">
                                            <svg class="w-2 h-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                 <path
                                                     d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 1 2 -2V7a2 2 0 0 1 -2 -2H5a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2z">
                                                 </path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($log->data['commitment_date'])->format('d M') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full py-10" style="color:#d1d5db;">
                            <p class="text-[10px] font-bold uppercase tracking-widest">No Recent Activity</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4 pt-4 flex items-center justify-between" style="border-top: 1px solid #fef2f2;">
                    <p class="text-[9px] font-bold uppercase tracking-widest italic" style="color:#9ca3af;">Global Optima
                        Sync</p>
                    <div class="flex -space-x-2">
                        @foreach ($liveTracking->take(3) as $log)
                            <div class="w-5 h-5 rounded-full border-2 border-white flex items-center justify-center text-[7px] font-bold"
                                style="background:#fde8e8; color:#e32b2b;">
                                {{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        
        <div class="w-full bg-white rounded-[2.5rem] p-8 shadow-xl border flex flex-col h-fit mb-10 relative overflow-hidden"
            style="border-color:#fde8e8; box-shadow: 0 20px 50px rgba(227,43,43,0.08);">
                
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-red-50 to-transparent rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="p-3.5 rounded-2xl shadow-lg" style="background: linear-gradient(135deg, #fef2f2, #fee2e2); color:#e32b2b;">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold tracking-tight" style="color:#1a1a2e;">Deployment Trend</h3>
                            <p class="text-[10px] font-bold uppercase tracking-widest mt-0.5" style="color:#9ca3af;">Live
                                Market Data</p>
                        </div>
                    </div>
                    <div class="flex p-1.5 rounded-2xl gap-1 shadow-sm" style="background: linear-gradient(135deg, #f8fafc, #f1f5f9);">
                        <button onclick="updateTrend('daily')" id="btn-daily"
                            class="filter-btn px-4 py-1.5 bg-white text-[10px] font-black uppercase tracking-wider rounded-xl shadow-sm transition-all duration-300 hover:shadow-md"
                            style="color:#e32b2b;">Daily</button>
                        <button onclick="updateTrend('weekly')" id="btn-weekly"
                            class="filter-btn px-4 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-xl transition-all duration-300 hover:bg-white hover:shadow-sm"
                            style="color:#9ca3af;">Weekly</button>
                        <button onclick="updateTrend('monthly')" id="btn-monthly"
                            class="filter-btn px-4 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-xl transition-all duration-300 hover:bg-white hover:shadow-sm"
                            style="color:#9ca3af;">Monthly</button>
                    </div>
                </div>

                
                <div class="flex flex-wrap items-end gap-3 mb-8 p-5 rounded-2xl border relative z-10"
                    style="background: linear-gradient(135deg, #fafafa, #f8fafc); border-color:#f1f5f9;">
                    <div class="flex-1 min-w-[120px]">
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1.5"
                            style="color:#64748b;">Datel</label>
                        <select id="trend-filter-datel" onchange="updateTrend()"
                            class="w-full rounded-xl border-slate-200 bg-white text-xs font-semibold py-2.5 px-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition shadow-sm">
                            <option value="">Semua Datel</option>
                            @foreach ($trendFilterOptions['datels'] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1.5"
                            style="color:#64748b;">STO</label>
                        <select id="trend-filter-sto" onchange="updateTrend()"
                            class="w-full rounded-xl border-slate-200 bg-white text-xs font-semibold py-2.5 px-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition shadow-sm">
                            <option value="">Semua STO</option>
                            @foreach ($trendFilterOptions['stos'] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label class="block text-[9px] font-bold uppercase tracking-widest mb-1.5"
                            style="color:#64748b;">Mitra</label>
                        <select id="trend-filter-mitra" onchange="updateTrend()"
                            class="w-full rounded-xl border-slate-200 bg-white text-xs font-semibold py-2.5 px-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition shadow-sm">
                            <option value="">Semua Mitra</option>
                            @foreach ($trendFilterOptions['mitras'] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button onclick="resetTrendFilters()"
                        class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all duration-300 hover:shadow-md"
                        style="color:#e32b2b; border: 1px solid #fde8e8; background: white;">
                        Reset
                    </button>
                </div>

                <div class="relative flex-1 w-full min-h-[280px] max-h-[320px] rounded-2xl overflow-hidden relative z-10" style="background: linear-gradient(180deg, #ffffff, #fafbfc);">
                    <canvas id="deploymentTrendChart"></canvas>
                </div>
            </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            
            <div class="lg:col-span-8 bg-white rounded-[2.5rem] p-8 shadow-xl border overflow-x-auto"
                style="border-color:#e0e7ff; box-shadow: 0 20px 40px rgba(59,130,246,0.06);" 
                    x-data="{ 
                        loading: false,
                        dates: [],
                        global_cap: 10,
                        selectedDay: null,
                        showModal: false,
                        currentYear: {{ now()->year }},
                        currentMonth: {{ now()->month }},
                        months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                        openDetails(day) {
                            if (day.count > 0) {
                                this.selectedDay = day;
                                this.showModal = true;
                            }
                        },
                        prevMonth() {
                            if (this.currentMonth === 1) {
                                this.currentMonth = 12;
                                this.currentYear--;
                            } else {
                                this.currentMonth--;
                            }
                            this.fetchWorkload();
                        },
                        nextMonth() {
                            if (this.currentMonth === 12) {
                                this.currentMonth = 1;
                                this.currentYear++;
                            } else {
                                this.currentMonth++;
                            }
                            this.fetchWorkload();
                        },
                        resetToCurrent() {
                            this.currentMonth = {{ now()->month }};
                            this.currentYear = {{ now()->year }};
                            this.fetchWorkload();
                        },
                        async fetchWorkload() {
                            this.loading = true;
                            try {
                                const res = await fetch(`/admin/api/workload-day?year=${this.currentYear}&month=${this.currentMonth}`);
                                const data = await res.json();
                                this.dates = data.week_headers || [];
                                this.global_cap = data.global_cap || 10;
                            } catch(e) {
                                console.error('Error fetching Workload Day:', e);
                            } finally {
                                this.loading = false;
                            }
                        },
                        getMitraColor(mitra) {
                            if (!mitra || mitra === 'Tanpa Mitra') return '#94a3b8';
                            const colors = [
                                '#ef4444', // red
                                '#3b82f6', // blue
                                '#10b981', // green
                                '#f59e0b', // amber
                                '#8b5cf6', // purple
                                '#ec4899', // pink
                                '#06b6d4', // cyan
                                '#f97316', // orange
                                '#14b8a6', // teal
                                '#84cc16', // lime
                            ];
                            let hash = 0;
                            for (let i = 0; i < mitra.length; i++) {
                                hash = ((hash << 5) - hash) + mitra.charCodeAt(i);
                                hash |= 0; // Convert to 32bit integer
                            }
                            const index = Math.abs(hash) % colors.length;
                            return colors[index];
                        }
                    }" x-init="fetchWorkload()">
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
                        <div class="flex items-center gap-3">
                            <div>
                                <h3 class="text-lg font-extrabold tracking-tight" style="color:#1a1a2e;">Workload Day</h3>
                                <p class="text-[10px] font-bold uppercase tracking-widest mt-0.5" style="color:#9ca3af;">Kapasitas Global Bulanan</p>
                            </div>
                            <a href="{{ route('admin.workload') }}" 
                                class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 font-extrabold text-[9px] uppercase tracking-wider rounded-lg transition-colors border border-blue-200 shadow-sm flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                Rincian Kerja
                            </a>
                        </div>
                        <div class="flex items-center gap-1.5 flex-wrap justify-end">
                            
                            <button @click="resetToCurrent()" 
                                x-show="currentMonth !== {{ now()->month }} || currentYear !== {{ now()->year }}" x-cloak
                                class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 font-extrabold text-[10px] uppercase tracking-wider rounded-lg transition-colors border border-blue-200 shadow-sm mr-1">
                                Bulan Ini
                            </button>
                            
                            
                            <div class="flex items-center bg-slate-50 p-1 rounded-xl border border-slate-200 shadow-sm">
                                <button @click="prevMonth()" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-white hover:shadow-sm rounded-lg transition-all focus:outline-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <div class="flex items-center font-extrabold text-xs text-slate-700 px-1 justify-center tracking-tight">
                                    <select x-model.number="currentMonth" @change="fetchWorkload()" class="bg-transparent border-none py-0 pl-2 pr-6 text-xs font-extrabold text-slate-700 focus:ring-0 cursor-pointer hover:text-blue-600 transition-colors" style="background-position: right 0.2rem center;">
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <select x-model.number="currentYear" @change="fetchWorkload()" class="bg-transparent border-none py-0 pl-1 pr-6 text-xs font-extrabold text-slate-700 focus:ring-0 cursor-pointer hover:text-blue-600 transition-colors -ml-2" style="background-position: right 0.2rem center;">
                                        @for ($i = now()->year - 5; $i <= now()->year + 5; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <button @click="nextMonth()" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-white hover:shadow-sm rounded-lg transition-all focus:outline-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-7 gap-1 md:gap-2 mb-2">
                        <template x-for="d in ['SEN','SEL','RAB','KAM','JUM','SAB','MIN']">
                            <div class="text-center text-[9px] font-black uppercase tracking-widest text-slate-400" x-text="d"></div>
                        </template>
                    </div>

                    <div class="grid grid-cols-7 gap-1 md:gap-2 relative">
                        <template x-for="(day, index) in dates" :key="index">
                            <div @click="openDetails(day)"
                                 class="flex flex-col h-[70px] md:h-[85px] rounded-xl relative overflow-hidden transition-all group"
                                 :class="{
                                     'ring-2 ring-blue-400 border-transparent shadow-md z-10': day.is_today,
                                     'cursor-pointer hover:-translate-y-0.5 hover:shadow-xl hover:ring-2 hover:ring-blue-300': day.count > 0,
                                     'cursor-default': day.count === 0,
                                     'bg-slate-50 border border-slate-200': day.in_month,
                                     'bg-slate-100/40 border border-slate-100 opacity-50 grayscale': !day.in_month
                                 }">
                                
                                <div class="absolute bottom-0 w-full transition-all duration-1000 ease-in-out flex-shrink-0"
                                     :style="'height: ' + Math.min((day.count / global_cap) * 100, 100) + '%;' +
                                     'background: ' + ((day.details && day.details.some(d => d.count > 3)) ? 'linear-gradient(0deg, #f87171, #ef4444)' : 'linear-gradient(0deg, #60a5fa, #3b82f6)')">
                                    <div class="absolute inset-0 opacity-30" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 10 Q 5 15, 10 10 T 20 10\' stroke=\'white\' fill=\'none\' stroke-width=\'2\'/%3E%3C/svg%3E'); background-size: 20px 20px; animation: moveWaves 2s linear infinite;"></div>
                                </div>
                                
                                
                                <div class="absolute top-2 left-2.5 z-10 text-left pointer-events-none">
                                    <span class="block text-[8px] font-black uppercase tracking-widest leading-tight opacity-80" :class="(day.count / global_cap) > 0.7 ? 'text-white' : 'text-slate-500'" x-text="day.day_label"></span>
                                    <span class="block text-[11px] font-extrabold leading-none mt-0.5" :class="(day.count / global_cap) > 0.7 ? 'text-white' : 'text-slate-700'" x-text="day.num_label.split(' ')[0]"></span>
                                </div>
                                
                                <!-- Mitra Indicators (Dots or small pills) -->
                                <div class="absolute top-[32px] left-2.5 z-10 flex gap-0.5 flex-wrap max-w-[65%] pointer-events-none">
                                    <template x-for="detail in day.details">
                                        <span class="w-1.5 h-1.5 rounded-full border shadow-sm" 
                                              :style="'background-color: ' + getMitraColor(detail.mitra)"
                                              :class="(day.count / global_cap) > 0.7 ? 'border-white/50' : 'border-slate-300/50'"></span>
                                    </template>
                                </div>
                                
                                
                                <div class="relative z-10 flex flex-col items-end justify-end h-full w-full p-2 text-right pointer-events-none">
                                    <span class="text-[16px] font-black leading-none drop-shadow-sm" :class="(day.count / global_cap) > 0.3 ? 'text-white' : 'text-slate-700'" x-text="day.count"></span>
                                    <span class="text-[7px] font-bold uppercase tracking-widest opacity-90 mt-0.5" :class="(day.count / global_cap) > 0.3 ? 'text-white' : 'text-slate-400'">Updates</span>
                                </div>
                            </div>
                        </template>
                        <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-white/50 backdrop-blur-sm z-20">
                            <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </div>

                        
                        <div x-show="!loading && dates.length === 0" class="absolute inset-0 flex flex-col items-center justify-center bg-white/80 backdrop-blur-sm z-10">
                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 1 2 -2V7a2 2 0 0 1 -2 -2H5a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2z"></path>
                            </svg>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum Ada Data</p>
                        </div>
                    </div>

                    
                    <div x-show="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition style="display: none;">
                        <div @click.away="showModal = false" class="bg-white rounded-[2rem] shadow-2xl p-6 md:p-8 w-full max-w-sm max-h-[85vh] flex flex-col relative"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-8 scale-95">
                            
                            
                            <button @click="showModal = false" class="absolute top-5 right-5 p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-slate-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            
                            <div class="mb-6 pr-6">
                                <h3 class="text-xl font-extrabold tracking-tight text-slate-800">Rincian Workload</h3>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="text-sm font-black text-blue-600" x-text="selectedDay ? selectedDay.num_label : ''"></span>
                                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full" x-text="selectedDay ? selectedDay.day_label : ''"></span>
                                </div>
                            </div>

                            <div class="flex-1 overflow-y-auto no-scrollbar space-y-3">
                                <template x-if="selectedDay && selectedDay.details && selectedDay.details.length > 0">
                                    <template x-for="(detail, i) in selectedDay.details" :key="i">
                                        <div class="flex items-center justify-between p-3.5 rounded-2xl border transition-colors"
                                             :class="detail.count > 3 ? 'bg-red-50 border-red-200 hover:border-red-300' : 'bg-slate-50 border-slate-100 hover:border-slate-200'"
                                             :style="'border-left: 4px solid ' + getMitraColor(detail.mitra)">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs shadow-sm"
                                                     :style="'background-color: ' + getMitraColor(detail.mitra) + '18; color: ' + getMitraColor(detail.mitra) + '; border: 1px solid ' + getMitraColor(detail.mitra) + '30'">
                                                    <span x-text="'#' + (i + 1)"></span>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold" :class="detail.count > 3 ? 'text-red-800' : 'text-slate-700'" x-text="detail.mitra"></span>
                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        <template x-for="stage in (detail.stages || [])">
                                                            <span class="text-[8px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded-md"
                                                                  style="background:rgba(59,130,246,0.1); color:#3b82f6;"
                                                                  x-text="stage"></span>
                                                        </template>
                                                        <template x-if="!detail.stages && detail.progres">
                                                            <span class="text-[8px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded-md"
                                                                  style="background:rgba(59,130,246,0.1); color:#3b82f6;"
                                                                  x-text="detail.progres"></span>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right flex flex-col items-end">
                                                <div class="flex items-center gap-1.5">
                                                    <svg x-show="detail.count > 3" class="w-4 h-4 text-red-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    <span class="text-lg font-black" :class="detail.count > 3 ? 'text-red-600' : 'text-slate-800'" x-text="detail.count"></span>
                                                </div>
                                                <span class="text-[7px] font-bold uppercase tracking-widest block -mt-1" :class="detail.count > 3 ? 'text-red-400' : 'text-slate-400'">Updates</span>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                                
                                <template x-if="!selectedDay || !selectedDay.details || selectedDay.details.length === 0">
                                    <div class="flex flex-col items-center justify-center py-10 opacity-50">
                                        <svg class="w-10 h-10 mb-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tidak ada record spesifik</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
            </div>

            
            <div class="lg:col-span-4 bg-white rounded-[2.5rem] p-8 shadow-xl border"
                style="border-color:#e0e7ff; box-shadow: 0 20px 40px rgba(59,130,246,0.06);" 
                    x-data="{ 
                        period: 'daily', 
                        dateFilter: '{{ \Carbon\Carbon::now()->format('Y-m-d') }}',
                        loading: false,
                        mitras: @js(array_values($topMitras->toArray())),
                        async fetchMitras() {
                            this.loading = true;
                            try {
                                const res = await fetch('/admin/api/top-mitras?date=' + this.dateFilter);
                                this.mitras = await res.json();
                            } catch(e) {
                                console.error('Error fetching Top Mitras:', e);
                            } finally {
                                this.loading = false;
                            }
                        }
                    }" x-init="fetchMitras()">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-extrabold tracking-tight" style="color:#1a1a2e;">Top Mitra</h3>
                            <p class="text-[10px] font-bold uppercase tracking-widest mt-0.5" style="color:#9ca3af;">Workload Analysis</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 items-end sm:items-center">
                            
                            <div class="relative">
                                <div x-show="loading" class="absolute -left-6 top-1/2 -translate-y-1/2">
                                    <svg class="animate-spin h-3.5 w-3.5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </div>
                            </div>
                            
                            <div class="flex p-1 rounded-xl" style="background:#f1f5f9;">
                                <button @click="period = 'daily'" :class="{'bg-white text-blue-600 shadow-sm': period === 'daily', 'text-slate-400 hover:text-slate-600': period !== 'daily'}" class="px-3 py-1.5 text-[9px] font-black uppercase tracking-wider rounded-lg transition-all">Daily</button>
                                <button @click="period = 'weekly'" :class="{'bg-white text-blue-600 shadow-sm': period === 'weekly', 'text-slate-400 hover:text-slate-600': period !== 'weekly'}" class="px-3 py-1.5 text-[9px] font-black uppercase tracking-wider rounded-lg transition-all">Weekly</button>
                                <button @click="period = 'monthly'" :class="{'bg-white text-blue-600 shadow-sm': period === 'monthly', 'text-slate-400 hover:text-slate-600': period !== 'monthly'}" class="px-3 py-1.5 text-[9px] font-black uppercase tracking-wider rounded-lg transition-all">Monthly</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-7 relative">
                        <template x-for="(mitra, index) in mitras" :key="index">
                            <div class="group relative bg-[#f8fafc] p-4 rounded-3xl border border-slate-100 hover:border-blue-100 hover:shadow-xl transition-all duration-300">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl flex flex-col items-center justify-center font-black shadow-sm group-hover:scale-105 transition-transform"
                                            :style="index === 0 ? 'background:#eff6ff; color:#3b82f6;' : 'background:#ffffff; color:#64748b;'">
                                            <span class="text-xs" x-text="'#' + (index + 1)"></span>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold truncate w-24 sm:w-32 lg:w-40" style="color:#334155;" x-text="mitra.name"></h4>
                                            <div class="flex items-center gap-1 mt-0.5 text-[9px] font-bold text-slate-400">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span x-text="mitra.avg_time + ' to Rekon'"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[9px] font-black block uppercase tracking-tighter" style="color:#94a3b8;">Total Vol</span>
                                        <span class="text-sm font-black" style="color:#334155;" x-text="mitra.total"></span>
                                    </div>
                                </div>

                                
                                <div class="relative w-full h-8 bg-slate-200/60 rounded-xl overflow-hidden shadow-inner flex items-center" style="transform: translateZ(0);">
                                    
                                    <div class="absolute inset-x-0 w-full flex justify-between px-3 z-20 text-[9px] font-black text-white mix-blend-difference uppercase tracking-widest pointer-events-none drop-shadow-md">
                                        <span x-text="(period === 'daily' ? mitra.daily : (period === 'weekly' ? mitra.weekly : mitra.monthly)) + ' ORDs'"></span>
                                        <span x-text="'Cap: ' + (period === 'daily' ? mitra.daily_cap : (period === 'weekly' ? mitra.weekly_cap : mitra.monthly_cap))"></span>
                                    </div>
                                    
                                    
                                    <div class="h-full relative transition-all duration-1000 ease-in-out flex-shrink-0"
                                         :style="'width: ' + Math.min(((period === 'daily' ? mitra.daily : (period === 'weekly' ? mitra.weekly : mitra.monthly)) / (period === 'daily' ? mitra.daily_cap : (period === 'weekly' ? mitra.weekly_cap : mitra.monthly_cap))) * 100, 100) + '%;' +
                                         'background: ' + (((period === 'daily' ? mitra.daily : (period === 'weekly' ? mitra.weekly : mitra.monthly)) / (period === 'daily' ? mitra.daily_cap : (period === 'weekly' ? mitra.weekly_cap : mitra.monthly_cap))) >= 1 ? 'linear-gradient(90deg, #f87171, #ef4444)' : 'linear-gradient(90deg, #60a5fa, #3b82f6)')">
                                        
                                        
                                        <div class="absolute inset-0 opacity-30" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 10 Q 5 15, 10 10 T 20 10\' stroke=\'white\' fill=\'none\' stroke-width=\'2\'/%3E%3C/svg%3E'); background-size: 20px 20px; animation: moveWaves 2s linear infinite;"></div>
                                        <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 10 Q 5 5, 10 10 T 20 10\' stroke=\'white\' fill=\'none\' stroke-width=\'1.5\'/%3E%3C/svg%3E'); background-size: 15px 15px; animation: moveWaves 1.5s linear infinite reverse;"></div>
                                    </div>
                                </div>
                                
                                
                                <div x-show="((period === 'daily' ? mitra.daily : (period === 'weekly' ? mitra.weekly : mitra.monthly)) / (period === 'daily' ? mitra.daily_cap : (period === 'weekly' ? mitra.weekly_cap : mitra.monthly_cap))) > 1" class="absolute -top-2 right-4 z-30 flex items-center justify-center" x-transition>
                                    <span class="animate-bounce bg-red-100 text-red-600 border border-red-200 text-[8px] font-black px-2 py-0.5 rounded-md uppercase shadow-lg tracking-widest">⚠️ Overload</span>
                                </div>
                            </div>
                        </template>

                        <div x-show="mitras.length === 0" class="flex flex-col items-center justify-center py-10 opacity-50">
                            <svg class="w-10 h-10 mb-2" style="color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Belum Ada Data</p>
                        </div>
                    </div>

                    <style>
                        @keyframes moveWaves {
                            0% { background-position: 0 0; }
                            100% { background-position: 40px 0; }
                        }
                    </style>
                </div>

            </div>
        </div>

    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    

    <script>
        // =============================================
        // LIVE TRACKING POLLING
        // =============================================
        function renderLiveTracking(logs) {
            const container = document.getElementById('liveTrackingContainer');
            const countBadge = document.getElementById('liveTrackingCount');
            if (!container) return;

            if (!logs || logs.length === 0) {
                container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full py-10" style="color:#d1d5db;">
                    <p class="text-[10px] font-bold uppercase tracking-widest">No Recent Activity</p>
                </div>`;
                if (countBadge) countBadge.textContent = '0 Updates';
                return;
            }

            if (countBadge) countBadge.textContent = `${logs.length} Updates`;

            container.innerHTML = logs.map(log => `
            <div class="flex items-start gap-3 p-3 rounded-2xl hover:bg-red-50 transition-colors border border-transparent hover:border-red-100">
                <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold border-2 border-white shadow-sm" style="background:#fef2f2; color:#e32b2b;">
                    ${log.user_initials}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-0.5">
                        <p class="text-[11px] font-black truncate" style="color:#1a1a2e;">${log.user_name}</p>
                        <p class="text-[9px] font-bold" style="color:#9ca3af;">${log.time_ago}</p>
                    </div>
                    <p class="text-[10px] font-medium" style="color:#6b7280;">Updated <span class="font-bold tracking-tight" style="color:#e32b2b;">#${log.star_click_id}</span></p>
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="text-[8px] font-black uppercase tracking-tighter px-1.5 py-0.5 rounded-md" style="background:#fef2f2; color:#e32b2b;">
                            ${log.progres ?? '-'}
                        </span>
                        ${log.commitment_date ? `
                                    <span class="text-[8px] font-black uppercase tracking-tighter px-1.5 py-0.5 rounded-md flex items-center gap-1" style="background:#fffbeb; color:#d97706;">
                                        <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 1 2 -2V7a2 2 0 0 1 -2 -2H5a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2z"></path></svg>
                                        ${log.commitment_date}
                                    </span>` : ''}
                    </div>
                </div>
            </div>
        `).join('');
        }

        function renderWaitingUsers(users) {
            const container = document.getElementById('waitingUsersContainer');
            const badge = document.getElementById('waitingApprovalBadge');
            if (!container) return;

            if (badge) {
                badge.textContent = users.length > 0 ? 'Action Required' : 'Clear';
                badge.style.background = users.length > 0 ? 'rgba(255,255,255,0.2)' : 'rgba(255,255,255,0.05)';
            }

            if (!users || users.length === 0) {
                container.innerHTML = `
                <div class="text-center py-10 opacity-60">
                    <svg class="w-10 h-10 mx-auto mb-2" style="color:rgba(255,255,255,0.3);" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round"></path>
                    </svg>
                    <p class="text-xs font-bold text-white">No users waiting</p>
                </div>`;
                return;
            }

            container.innerHTML = users.map(user => `
                <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/20 transition-colors border"
                    style="background:rgba(255,255,255,0.1); border-color:rgba(255,255,255,0.1);">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-black text-xs uppercase shadow-sm"
                            style="background:white; color:#e32b2b;">
                            ${user.initial}
                        </div>
                        <div>
                            <p class="text-xs font-bold leading-none text-white">${user.name}</p>
                            ${user.requested_role ? `
                                    <span class="inline-block mt-1 text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md"
                                        style="background:rgba(255,255,255,0.2); color:rgba(255,255,255,0.9);">
                                        Request: ${user.requested_role}
                                    </span>` : ''}
                            <p class="text-[10px] mt-0.5" style="color:rgba(255,255,255,0.5);">
                                ${user.time_ago}</p>
                        </div>
                    </div>
                    <a href="${user.route}"
                        class="p-2 rounded-xl hover:scale-110 transition-transform shadow-lg"
                        style="background:white; color:#e32b2b;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 13l4 4L19 7"></path>
                        </svg>
                    </a>
                </div>
            `).join('');
        }

        var _liveTrackingPending = false;

        async function pollLiveTracking() {
            if (_liveTrackingPending) return;
            _liveTrackingPending = true;
            try {
                const res = await fetch('{{ route('admin.api.live-tracking') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (res.status === 401 || res.status === 403) {
                    if (window._liveTrackingInterval) clearInterval(window._liveTrackingInterval);
                    return;
                }
                if (!res.ok) return;
                const data = await res.json();

                // Mendukung versi endpoint baru
                if (data && data.activities !== undefined) {
                    renderLiveTracking(data.activities);
                    renderWaitingUsers(data.waiting || []);
                } else {
                    renderLiveTracking(data);
                }
            } catch (e) {} finally {
                _liveTrackingPending = false;
            }
        }

        // =============================================
        // DASHBOARD INIT
        // =============================================
        function initDashboard() {
            // Bersihkan interval lama jika ada
            if (window._dashboardInterval) {
                clearInterval(window._dashboardInterval);
                window._dashboardInterval = null;
            }
            if (window._liveTrackingInterval) {
                clearInterval(window._liveTrackingInterval);
                window._liveTrackingInterval = null;
            }

            // --- TREND CHART ---
            const ctxTrend = document.getElementById('deploymentTrendChart');
            if (ctxTrend) {
                // Destroy chart lama jika ada (penting untuk Turbo Drive)
                if (window._trendChart instanceof Chart) {
                    window._trendChart.destroy();
                    window._trendChart = null;
                }

                // Enhanced gradient with multiple stops
                const gradient = ctxTrend.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(227, 43, 43, 0.4)');
                gradient.addColorStop(0.5, 'rgba(227, 43, 43, 0.15)');
                gradient.addColorStop(1, 'rgba(227, 43, 43, 0.02)');

                window._trendChart = new Chart(ctxTrend.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: @json($trendLabels),
                        datasets: [{
                            label: 'Volume Deployment',
                            data: @json($trendValues),
                            borderColor: '#e32b2b',
                            borderWidth: 3,
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#e32b2b',
                            pointBorderWidth: 3,
                            pointRadius: 4,
                            pointHoverRadius: 8,
                            pointHoverBorderWidth: 4,
                            pointHoverBackgroundColor: '#e32b2b',
                            pointHoverBorderColor: '#fff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
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
                                padding: 12,
                                cornerRadius: 12,
                                displayColors: false,
                                boxPadding: 4,
                                callbacks: {
                                    label: (c) => ` Volume: ${c.parsed.y} order`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.6)',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        weight: '600',
                                        size: 11
                                    },
                                    color: '#64748b',
                                    stepSize: 1,
                                    padding: 10
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        weight: '600',
                                        size: 11
                                    },
                                    color: '#64748b',
                                    padding: 10
                                }
                            }
                        }
                    }
                });
            }

            // Restore active filter button state
            const activeFilter = window._dashboardFilter || 'monthly';
            const activeBtn = document.getElementById(`btn-${activeFilter}`);
            if (activeBtn) {
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.style.background = '';
                    btn.style.color = '#9ca3af';
                    btn.classList.remove('shadow-sm');
                });
                activeBtn.style.background = 'white';
                activeBtn.style.color = '#e32b2b';
                activeBtn.classList.add('shadow-sm');
            }

            // --- LIVE TRACKING POLLING (setiap 30 detik) ---
            pollLiveTracking(); // langsung fetch saat halaman dimuat
            window._liveTrackingInterval = setInterval(pollLiveTracking, 30000);
        }

        async function updateTrend(filter) {
            if (filter) window._dashboardFilter = filter;
            const activeFilter = window._dashboardFilter || 'daily';

            // Update button UI
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.style.background = '';
                btn.style.color = '#9ca3af';
                btn.classList.remove('shadow-sm');
            });
            const activeBtn = document.getElementById(`btn-${activeFilter}`);
            if (activeBtn) {
                activeBtn.style.background = 'white';
                activeBtn.style.color = '#e32b2b';
                activeBtn.classList.add('shadow-sm');
            }

            // Collect filter values
            const datel = document.getElementById('trend-filter-datel')?.value || '';
            const sto = document.getElementById('trend-filter-sto')?.value || '';
            const mitra = document.getElementById('trend-filter-mitra')?.value || '';

            const params = new URLSearchParams({
                filter: activeFilter
            });
            if (datel) params.set('datel', datel);
            if (sto) params.set('sto', sto);
            if (mitra) params.set('mitra', mitra);

            try {
                const response = await fetch(`{{ route('admin.api.trend-data') }}?${params.toString()}`);
                const data = await response.json();

                if (window._trendChart instanceof Chart) {
                    window._trendChart.data.labels = data.labels;
                    window._trendChart.data.datasets[0].data = data.values;
                    window._trendChart.update();
                }
            } catch (e) {
                console.error('Trend update failed', e);
            }
        }

        function resetTrendFilters() {
            const selects = ['trend-filter-datel', 'trend-filter-sto', 'trend-filter-mitra'];
            selects.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            updateTrend();
        }

        // Cleanup sebelum Turbo meng-cache halaman — WAJIB agar chart tidak corrupt saat restore
        document.addEventListener('turbo:before-cache', function() {
            if (window._trendChart instanceof Chart) {
                window._trendChart.destroy();
                window._trendChart = null;
            }
            if (window._dashboardInterval) {
                clearInterval(window._dashboardInterval);
                window._dashboardInterval = null;
            }
            if (window._liveTrackingInterval) {
                clearInterval(window._liveTrackingInterval);
                window._liveTrackingInterval = null;
            }
        });

        // =============================================
        // BOOTSTRAP — pastikan Chart.js sudah siap sebelum init
        // =============================================
        function loadChartJsAndInit() {
            if (typeof Chart !== 'undefined') {
                initDashboard();
            } else {
                const existing = document.querySelector('script[data-chartjs]');
                if (existing) {
                    existing.addEventListener('load', initDashboard);
                } else {
                    const s = document.createElement('script');
                    s.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                    s.setAttribute('data-chartjs', '1');
                    s.onload = initDashboard;
                    document.head.appendChild(s);
                }
            }
        }

        document.addEventListener('turbo:load', loadChartJsAndInit);
        document.addEventListener('DOMContentLoaded', loadChartJsAndInit);

        // =============================================
        // LIVE CLOCK
        // =============================================
        function updateClock() {
            const now = new Date();

            const timeEl = document.getElementById('live-clock');
            const dateEl = document.getElementById('live-date');
            if (!timeEl || !dateEl) return;

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            timeEl.textContent = `${hours}:${minutes}:${seconds}`;

            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            dateEl.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
        }

        // Start clock and keep it alive across Turbo navigations
        if (window._clockInterval) clearInterval(window._clockInterval);
        updateClock();
        window._clockInterval = setInterval(updateClock, 1000);

        document.addEventListener('turbo:before-cache', function() {
            if (window._clockInterval) {
                clearInterval(window._clockInterval);
                window._clockInterval = null;
            }
        });
    </script>
@endsection

