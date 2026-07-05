<div class="relative overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-sm text-left text-slate-600">

        
        <thead class="text-xs text-slate-500 uppercase border-b border-slate-200 sticky top-0 z-20" style="background:#fafafa;">
            <tr>
                <th class="sticky left-0 z-40 bg-slate-50 px-6 py-4 border-r border-slate-200 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] whitespace-nowrap">
                    Star Click ID
                </th>

                @foreach ([
                    'Track ID','Ticket ID','Star Click Status','Status Alokasi Alpro',
                    'ID ODP','Nama ODP','Reservation ID','Nama Pengguna','Username/NIK',
                    'Latitude','Longitude','Sales Code','Remark','Segment','CFU',
                    'Source App','Disurvey Pada','Estimasi Go Live','Real Go Live',
                    'Initial Date','Finish Install Date','Regional','Witel','Witel Lama',
                    'Datel','STO','WOK','Nama Customer','Telkomsel Area','Telkomsel Regional',
                    'Telkomsel Branch','Telkomsel Cluster','Status Order','Validasi Planning',
                    'iHLD LoP ID','eProposal LoP ID','eProposal Parent ID','Kode Program',
                    'Nama Proyek','Tipe Desain','Total BOQ','Capex / Port','ODP Total',
                    'Total Port','Batch Program','Status eProposal','Status TOMPS',
                    'TOMPS Last Activity','Status SAP','Status Proyek','Jenis Program',
                    'ODP Go Live','Waiting Caring','Submitted eProposal',
                    'Inisiasi TOMPS','Validasi ABD','Go Live TOMPS','Ditambahkan Pada',
                    'Username Pembuat','Kategori Mitra','Nama Mitra',
                    'Revenue Plan','Nama CFU','Tahun','Kategori'
                ] as $head)
                    <th class="px-6 py-4 whitespace-nowrap">
                        {{ $head }}
                    </th>
                @endforeach
            </tr>
        </thead>

        
        <tbody class="divide-y divide-slate-100">
            @forelse ($rows as $row)
                <tr class="hover:bg-red-50/30 transition group">

                    
                    <td class="sticky left-0 z-10 bg-white group-hover:bg-slate-50 px-6 py-4 font-medium text-slate-900 border-r border-slate-100 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)] whitespace-nowrap">
                        {{ $row->star_click_id ?? '-' }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->track_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->ticket_id }}</td>

                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :value="$row->star_click_status" />
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :value="$row->status_alokasi_alpro" />
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->id_odp_alokasi_alpro }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->nama_odp_alokasi_alpro }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->reservation_id_alokasi_alpro }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->nama_pengguna_melakukan_alokasi_alpro }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->username_nik_alokasi_alpro }}</td>

                    <td class="px-6 py-4 whitespace-nowrap font-mono text-xs">{{ $row->latitude }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-mono text-xs">{{ $row->longitude }}</td>

                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->sales_code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $row->remark }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->segment }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->cfu }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->source_app }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->disurvey_pada }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->estimasi_go_live }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->real_go_live }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->initial_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->finish_install_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->regional }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->witel }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->witel_lama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->datel }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->sto }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->wok }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->nama_customer }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->telkomsel_area }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->telkomsel_regional }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->telkomsel_branch }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->telkomsel_cluster }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :value="$row->status_order" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->validasi_planning }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->ihld_lop_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->eproposal_lop_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->eproposal_lop_parent_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->kode_program }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->nama_proyek }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tipe_desain }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->total_boq }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->capex_per_port }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->odp_total }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->total_port }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->batch_program }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :value="$row->status_eproposal" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :value="$row->status_tomps" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->status_tomps_last_activity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :value="$row->status_sap" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :value="$row->status_proyek" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :value="$row->jenis_program" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->odp_go_live }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal_waiting_caring }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal_submitted_to_eproposal }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal_inisiasi_tomps }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal_validasi_abd_tomps }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tanggal_go_live_tomps }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->ditambahkan_pada }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->username_nik_pembuat }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->kategori_mitra }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->nama_mitra }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->revenue_plan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :value="$row->nama_cfu" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->tahun }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $row->kategori }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="70" class="py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <h3 class="text-lg font-medium text-slate-800">Tidak ada data ditemukan</h3>
                            <p class="text-slate-500 text-sm mt-1">Belum ada history upload yang tersedia.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $rows->links('components.pagination') }}
</div>
