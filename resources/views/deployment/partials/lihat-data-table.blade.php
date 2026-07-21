@php
    $isAdmin = auth()->user()->role === 'admin';
    $userHeaders = ['Starclick ID', 'Nama', 'Nama Mitra', 'Alamat', 'Telepon', 'Tikor', 'Datel', 'STO', 'Batch'];
    $adminHeaders = ['Status Alokasi', 'Status Order', 'LoP ID', 'Tipe Desain', 'Total BOQ', 'Jenis Program', 'Nama CFU', 'Status Proyek'];
    
    $headers = $userHeaders;
    if ($isAdmin) {
        $headers = array_merge($headers, $adminHeaders);
    }
    $headers = array_merge($headers, ['Progres', 'Usia Order', 'Action']);
@endphp

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-slate-600">
        <thead class="text-xs text-slate-500 uppercase border-b border-slate-200" style="background:#fafafa;">
            <tr>
                <th class="px-6 py-4 font-semibold sticky left-0 bg-slate-50 z-10 border-r border-slate-100 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)]">
                    NDE JT
                </th>
                @foreach ($headers as $head)
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
                    {{ $row->nde_jt }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap">{{ $row->star_click_id }}</td>
                <td class="px-6 py-4 min-w-[200px]">{{ $row->nama_customer }}</td>
                <td class="px-6 py-4 min-w-[150px]">{{ $row->nama_mitra }}</td>
                <td class="px-6 py-4 min-w-[250px] truncate max-w-xs" title="">{{ $row->alamat_pelanggan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $row->telepon_pelanggan }}</td>
                <td class="px-6 py-4 whitespace-nowrap font-mono text-xs">{{ $row->tikor_pelanggan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $row->datel }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $row->sto ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $row->nomor_batch ?? '-' }}</td>

                @if($isAdmin)
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->status_alokasi_alpro" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->status_order" />
                </td>

                <td class="px-6 py-4 whitespace-nowrap">{{ optional($row->planning)->ihld_lop_id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ optional($row->planning)->tipe_desain }}</td>
                <td class="px-6 py-4 whitespace-nowrap font-mono">
                    {{ optional($row->planning)->total_boq ? number_format(optional($row->planning)->total_boq, 0, ',', '.') : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->jenis_program" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->nama_cfu" />
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="optional($row->planning)->status_proyek" />
                </td>
                @endif

                <td class="px-6 py-4 whitespace-nowrap">
                    <x-status-badge :value="$row->progres" />
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    @if($row->created_at)
                        @php
                            $isSelesai = in_array(strtolower(optional($row->planning)->status_order ?? ''), ['selesai', 'closed', 'cancel', 'drop', 'completed']);
                            $akhir = ($isSelesai && $row->tanggal_update_progres) ? \Carbon\Carbon::parse($row->tanggal_update_progres) : now();
                            $diffUsia = $row->created_at->diff($akhir);
                            $usiaArr = [];
                            if ($diffUsia->d > 0) $usiaArr[] = $diffUsia->d . ' hr';
                            if ($diffUsia->h > 0) $usiaArr[] = $diffUsia->h . ' jam';
                            if ($diffUsia->i > 0) $usiaArr[] = $diffUsia->i . ' mnt';
                            $strUsiaOrder = empty($usiaArr) ? 'Baru saja' : implode(' ', $usiaArr);
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-blue-50 text-blue-600 border border-blue-100">
                            {{ $strUsiaOrder }}
                        </span>
                    @else
                        <span class="text-xs text-slate-400 italic">—</span>
                    @endif
                </td>

                <td class="px-4 py-3 text-center whitespace-nowrap sticky right-0 bg-white group-hover:bg-red-50 z-10 border-l border-slate-100">
                    <a href="{{ route('deployment.lihat-data.detail', $row->id) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold
                              bg-white border border-slate-200 text-slate-700 shadow-sm
                              hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Lihat
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ $isAdmin ? 21 : 13 }}" class="px-6 py-12 text-center">
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
