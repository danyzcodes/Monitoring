<?php

namespace App\Exports;

use App\Models\EbisPlanningOrder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class EbisPlanningExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return EbisPlanningOrder::query()->orderBy('id', 'desc');
    }

    public function headings(): array
    {
        return [
            'Starclick ID',
            'Track ID',
            'Ticket ID',
            'Starclick Status',
            'Status Alokasi Alpro',
            'ID ODP Alokasi Alpro',
            'Nama ODP Alokasi Alpro',
            'Reservation ID Alokasi Alpro',
            'Nama Pengguna Alokasi Alpro',
            'Username NIK Alokasi Alpro',
            'Latitude',
            'Longitude',
            'Sales Code',
            'Remark',
            'Segment',
            'CFU',
            'Source App',
            'Disurvey Pada',
            'Estimasi Go Live',
            'Real Go Live',
            'Initial Date',
            'Finish Install Date',
            'Regional',
            'Witel',
            'Witel Lama',
            'Datel',
            'STO',
            'WOK',
            'Nama Customer',
            'Telkomsel Area',
            'Telkomsel Regional',
            'Telkomsel Branch',
            'Telkomsel Cluster',
            'Status Order',
            'Validasi Planning',
            'iHLD LoP ID',
            'eProposal LOP ID',
            'eProposal LOP Parent ID',
            'Kode Program',
            'Nama Proyek',
            'Tipe Desain',
            'Total BOQ',
            'Capex Per Port',
            'ODP Total',
            'Total Port',
            'Batch Program',
            'Status eProposal',
            'Status TOMPS',
            'Status TOMPS Last Activity',
            'Status SAP',
            'Status Proyek',
            'Jenis Program',
            'ODP Go Live',
            'Tanggal Waiting Caring',
            'Tanggal Submitted to eProposal',
            'Tanggal Inisiasi TOMPS',
            'Tanggal Validasi ABD TOMPS',
            'Tanggal Go Live TOMPS',
            'Ditambahkan Pada',
            'Username NIK Pembuat',
            'Kategori Mitra',
            'Nama Mitra',
            'Revenue Plan',
            'Nama CFU',
            'Tahun',
            'Kategori',
            'Progres',
            'Tanggal Update Progres'
        ];
    }

    public function map($row): array
    {
        return [
            $row->star_click_id ?? '-',
            $row->track_id ?? '-',
            $row->ticket_id ?? '-',
            $row->star_click_status ?? '-',
            $row->status_alokasi_alpro ?? '-',
            $row->id_odp_alokasi_alpro ?? '-',
            $row->nama_odp_alokasi_alpro ?? '-',
            $row->reservation_id_alokasi_alpro ?? '-',
            $row->nama_pengguna_melakukan_alokasi_alpro ?? '-',
            $row->username_nik_alokasi_alpro ?? '-',
            $row->latitude ?? '-',
            $row->longitude ?? '-',
            $row->sales_code ?? '-',
            $row->remark ?? '-',
            $row->segment ?? '-',
            $row->cfu ?? '-',
            $row->source_app ?? '-',
            $row->disurvey_pada ? Carbon::parse($row->disurvey_pada)->format('d-m-Y') : '-',
            $row->estimasi_go_live ? Carbon::parse($row->estimasi_go_live)->format('d-m-Y') : '-',
            $row->real_go_live ? Carbon::parse($row->real_go_live)->format('d-m-Y') : '-',
            $row->initial_date ? Carbon::parse($row->initial_date)->format('d-m-Y') : '-',
            $row->finish_install_date ? Carbon::parse($row->finish_install_date)->format('d-m-Y') : '-',
            $row->regional ?? '-',
            $row->witel ?? '-',
            $row->witel_lama ?? '-',
            $row->datel ?? '-',
            $row->sto ?? '-',
            $row->wok ?? '-',
            $row->nama_customer ?? '-',
            $row->telkomsel_area ?? '-',
            $row->telkomsel_regional ?? '-',
            $row->telkomsel_branch ?? '-',
            $row->telkomsel_cluster ?? '-',
            $row->status_order ?? '-',
            $row->validasi_planning ?? '-',
            $row->ihld_lop_id ?? '-',
            $row->eproposal_lop_id ?? '-',
            $row->eproposal_lop_parent_id ?? '-',
            $row->kode_program ?? '-',
            $row->nama_proyek ?? '-',
            $row->tipe_desain ?? '-',
            $row->total_boq ? number_format($row->total_boq, 0, ',', '.') : '-',
            $row->capex_per_port ? number_format($row->capex_per_port, 0, ',', '.') : '-',
            $row->odp_total ?? '-',
            $row->total_port ?? '-',
            $row->batch_program ?? '-',
            $row->status_eproposal ?? '-',
            $row->status_tomps ?? '-',
            $row->status_tomps_last_activity ?? '-',
            $row->status_sap ?? '-',
            $row->status_proyek ?? '-',
            $row->jenis_program ?? '-',
            $row->odp_go_live ?? '-',
            $row->tanggal_waiting_caring ? Carbon::parse($row->tanggal_waiting_caring)->format('d-m-Y') : '-',
            $row->tanggal_submitted_to_eproposal ? Carbon::parse($row->tanggal_submitted_to_eproposal)->format('d-m-Y') : '-',
            $row->tanggal_inisiasi_tomps ? Carbon::parse($row->tanggal_inisiasi_tomps)->format('d-m-Y') : '-',
            $row->tanggal_validasi_abd_tomps ? Carbon::parse($row->tanggal_validasi_abd_tomps)->format('d-m-Y') : '-',
            $row->tanggal_go_live_tomps ? Carbon::parse($row->tanggal_go_live_tomps)->format('d-m-Y') : '-',
            $row->ditambahkan_pada ? Carbon::parse($row->ditambahkan_pada)->format('d-m-Y') : '-',
            $row->username_nik_pembuat ?? '-',
            $row->kategori_mitra ?? '-',
            $row->nama_mitra ?? '-',
            $row->revenue_plan ? number_format($row->revenue_plan, 0, ',', '.') : '-',
            $row->nama_cfu ?? '-',
            $row->tahun ?? '-',
            $row->kategori ?? '-',
            $row->progres ?? '-',
            $row->tanggal_update_progres ? Carbon::parse($row->tanggal_update_progres)->format('d-m-Y H:i:s') : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'DC2626'],
                ],
            ],
        ];
    }
}
