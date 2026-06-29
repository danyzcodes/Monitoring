<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-slate-600">
        <thead class="text-xs text-slate-500 uppercase border-b border-slate-200" style="background:#fafafa;">
            <tr>
                <th class="px-6 py-4 font-semibold sticky left-0 bg-slate-50 z-10 border-r border-slate-100 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)]">
                    NDE JT
                </th>
                @foreach (['Starclick ID', 'Nama', 'Alamat', 'Telepon', 'Tikor', 'Datel', 'STO', 'Batch', 'Status Alokasi', 'Status Order', 'LoP ID', 'Tipe Desain', 'Total BOQ', 'Program', 'CFU', 'Status Proyek', 'Progres', 'Usia Order', 'Action'] as $head)
                    <th class="px-6 py-4 font-semibold whitespace-nowrap {{ $head === 'Action' ? 'text-center sticky right-0 bg-slate-50 z-10 border-l border-slate-100' : '' }}">
                        {{ $head }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($rows as $row)
            <tr class="hover:bg-red-50/30 transition group">
                
                <td class="px-6 py-4 font-medium text-slate-900 sticky left-0 bg-white group-hover:bg-red-50 z-10 border-r border-slate-100 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)]">
                    {{ \App\Helpers\MaskHelper::mask($row->nde_jt) }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap">{{ \App\Helpers\MaskHelper::mask($row->star_click_id) }}</td>
                <td class="px-6 py-4 min-w-[200px]">{{ \App\Helpers\MaskHelper::mask($row->nama_customer) }}</td>
                <td class="px-6 py-4 min-w-[250px] truncate max-w-xs" title="">{{ \App\Helpers\MaskHelper::mask($row->alamat_pelanggan) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ \App\Helpers\MaskHelper::mask($row->telepon_pelanggan) }}</td>
                <td class="px-6 py-4 whitespace-nowrap font-mono text-xs">{{ \App\Helpers\MaskHelper::mask($row->tikor_pelanggan) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ \App\Helpers\MaskHelper::mask($row->datel) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $row->sto ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $row->nomor_batch ?? '-' }}</td>

                
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->status_alokasi_alpro" mask />
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->status_order" mask />
                </td>

                <td class="px-6 py-4 whitespace-nowrap">{{ \App\Helpers\MaskHelper::mask(optional($row->planning)->ihld_lop_id) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ \App\Helpers\MaskHelper::mask(optional($row->planning)->tipe_desain) }}</td>
                <td class="px-6 py-4 whitespace-nowrap font-mono">
                    {{ optional($row->planning)->total_boq ? \App\Helpers\MaskHelper::mask(number_format(optional($row->planning)->total_boq, 0, ',', '.')) : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->jenis_program" mask />
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->nama_cfu" mask />
                </td>

                
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->status_proyek" mask />
                </td>

                
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="$row->progres" />
                </td>

                
                 <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $commitmentDate = $row->data['commitment_date'] ?? null;
                    @endphp
                    
                    @if($commitmentDate)
                        @php
                            $target = \Carbon\Carbon::parse($commitmentDate)->startOfDay();
                            $isSelesai = in_array(strtoupper($row->progres ?? ''), ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON', 'SELESAI FISIK']);
                            
                            if ($isSelesai && $row->tanggal_update_progres) {
                                // Sudah selesai: hitung selisih hari waktu selesai vs deadline
                                $selesaiDate = \Carbon\Carbon::parse($row->tanggal_update_progres)->startOfDay();
                                $diffHari = $selesaiDate->diffInDays($target, false); // false = return negative if target < selesaiDate
                                
                                if ($diffHari < 0) {
                                    $statusText = 'Telat ' . abs($diffHari) . ' hr';
                                    $bgClass = 'bg-red-50 text-red-600 border-red-200';
                                } else {
                                    $statusText = 'Tepat Waktu';
                                    $bgClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                }
                            } else {
                                // Belum selesai: hitung selisih hari ini vs deadline
                                $today = now()->startOfDay();
                                $diffHari = $today->diffInDays($target, false); // false = return negative if target < today
                                
                                if ($diffHari < 0) {
                                    $statusText = 'Overdue ' . abs($diffHari) . ' hr';
                                    $bgClass = 'bg-red-50 text-red-600 border-red-200 font-bold animate-pulse';
                                } elseif ($diffHari <= 3) {
                                    $statusText = 'Sisa ' . $diffHari . ' hr';
                                    $bgClass = 'bg-amber-50 text-amber-600 border-amber-200';
                                } else {
                                    $statusText = 'Sisa ' . $diffHari . ' hr';
                                    $bgClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                }
                            }
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium border {{ $bgClass }}">
                            {{ $statusText }}
                        </span>
                        <div class="text-[9px] text-slate-400 mt-0.5">Tgt: {{ $target->format('d/m/y') }}</div>
                    @else
                        <span class="text-xs text-slate-400 italic">—</span>
                    @endif
                </td>

                
                <td class="px-4 py-3 text-center whitespace-nowrap sticky right-0 bg-white group-hover:bg-red-50 z-10 border-l border-slate-100">
                   <a href="{{ route('deployment.edit', $row->id) }}" 
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold
                             bg-white border border-slate-200 text-slate-700 shadow-sm
                             hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Update
                   </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="19" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-800">Tidak ada data ditemukan</h3>
                        <p class="text-slate-500 mt-1 text-sm">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="px-6 py-4" style="border-top: 1px solid #fef2f2; background:#fafafa;">
    {{ $rows->links('components.pagination') }}
</div>
