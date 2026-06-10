<?php

namespace App\Imports;

use App\Models\EbisPlanningOrder;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;


class EbisPlanningImport implements OnEachRow, WithHeadingRow
{
    
    private function cleanDate($value)
    {
        if ($value === null || $value === '' || $value === '-') {
            return null;
        }

        try {
            
            if (is_numeric($value)) {
                return Carbon::instance(
                    ExcelDate::excelToDateTimeObject($value)
                )->format('Y-m-d');
            }

            
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    
    private function cleanNumber($value)
    {
        if ($value === null || $value === '' || $value === '-') {
            return null;
        }
        

        $value = str_replace(',', '', $value);
        return is_numeric($value) ? $value : null;
    }
    

    public function onRow(Row $row)
    {
        $r = $row->toArray();

        
        if (empty(array_filter($r))) {
            return;
        }

        
        $excelData = [
            'track_id'                              => $r['track_id'] ?? null,
            'ticket_id'                             => $r['ticket_id'] ?? null,
            'star_click_status'                     => $r['star_click_status'] ?? null,
            'status_alokasi_alpro'                  => $r['status_alokasi_alpro'] ?? null,
            'id_odp_alokasi_alpro'                  => $r['id_odp_alokasi_alpro'] ?? null,
            'nama_odp_alokasi_alpro'                => $r['nama_odp_alokasi_alpro'] ?? null,
            'reservation_id_alokasi_alpro'          => $r['reservation_id_alokasi_alpro'] ?? null,
            'nama_pengguna_melakukan_alokasi_alpro'  => $r['nama_pengguna_melakukan_alokasi_alpro'] ?? null,
            'username_nik_melakukan_alokasi_alpro'   => $r['username_nik_melakukan_alokasi_alpro'] ?? null,
            'latitude'                              => $this->cleanNumber($r['latitude'] ?? null),
            'longitude'                             => $this->cleanNumber($r['longitude'] ?? null),
            'sales_code'                            => $r['sales_code'] ?? null,
            'remark'                                => $r['remark'] ?? null,
            'segment'                               => $r['segment'] ?? null,
            'cfu'                                   => $r['cfu'] ?? null,
            'source_app'                            => $r['source_app'] ?? null,
            'disurvey_pada'                         => $this->cleanDate($r['disurvey_pada'] ?? null),
            'estimasi_go_live'                      => $this->cleanDate($r['estimasi_go_live'] ?? null),
            'real_go_live'                          => $this->cleanDate($r['real_go_live'] ?? null),
            'initial_date'                          => $this->cleanDate($r['initial_date'] ?? null),
            'finish_install_date'                   => $this->cleanDate($r['finish_install_date'] ?? null),
            'regional'                              => $r['regional'] ?? null,
            'witel'                                 => $r['witel'] ?? null,
            'witel_lama'                            => $r['witel_lama'] ?? null,
            'datel'                                 => $r['datel'] ?? null,
            'sto'                                   => $r['sto'] ?? null,
            'wok'                                   => $r['wok'] ?? null,
            'nama_customer'                         => $r['nama_customer'] ?? null,
            'telkomsel_area'                        => $r['telkomsel_area'] ?? null,
            'telkomsel_regional'                    => $r['telkomsel_regional'] ?? null,
            'telkomsel_branch'                      => $r['telkomsel_branch'] ?? null,
            'telkomsel_cluster'                     => $r['telkomsel_cluster'] ?? null,
            'status_order'                          => $r['status_order'] ?? null,
            'validasi_planning'                     => $r['validasi_planning'] ?? null,
            'ihld_lop_id'                           => $r['ihld_lop_id'] ?? null,
            'eproposal_lop_id'                      => $r['eproposal_lop_id'] ?? null,
            'eproposal_lop_parent_id'               => $r['eproposal_lop_parent_id'] ?? null,
            'kode_program'                          => $r['kode_program'] ?? null,
            'nama_proyek'                           => $r['nama_proyek'] ?? null,
            'tipe_desain'                           => $r['tipe_desain'] ?? null,
            'total_boq'                             => $this->cleanNumber($r['total_boq'] ?? null),
            'capex_per_port'                        => $this->cleanNumber($r['capex_per_port'] ?? null),
            'odp_total'                             => $this->cleanNumber($r['odp_total'] ?? null),
            'total_port'                            => $this->cleanNumber($r['total_port'] ?? null),
            'batch_program'                         => $r['batch_program'] ?? null,
            'status_eproposal'                      => $r['status_eproposal'] ?? null,
            'status_tomps'                          => $r['status_tomps'] ?? null,
            'status_tomps_last_activity'             => $r['status_tomps_last_activity'] ?? null,
            'status_sap'                            => $r['status_sap'] ?? null,
            'status_proyek'                         => $r['status_proyek'] ?? null,
            'odp_go_live'                           => $r['odp_go_live'] ?? null,
            'tanggal_waiting_caring'                => $this->cleanDate($r['tanggal_waiting_caring'] ?? null),
            'tanggal_submitted_to_eproposal'        => $r['tanggal_submitted_to_eproposal'] ?? null,
            'tanggal_inisiasi_tomps'                => $this->cleanDate($r['tanggal_inisiasi_tomps'] ?? null),
            'tanggal_validasi_abd_tomps'             => $r['tanggal_validasi_abd_tomps'] ?? null,
            'tanggal_go_live_tomps'                 => $r['tanggal_go_live_tomps'] ?? null,
            'ditambahkan_pada'                      => $this->cleanDate($r['ditambahkan_pada'] ?? null),
            'username_nik_pembuat'                  => $r['username_nik_pembuat'] ?? null,
            'kategori_mitra'                        => $r['kategori_mitra'] ?? null,
            'nama_mitra'                            => $r['nama_mitra'] ?? null,
            'revenue_plan'                          => $this->cleanNumber($r['revenue_plan'] ?? null),
            'nama_cfu'                              => $r['nama_cfu'] ?? null,
            'jenis_program'                         => $r['jenis_program'] ?? null,
            'tahun'                                 => $this->cleanNumber($r['tahun'] ?? null),
            'kategori'                              => $r['kategori'] ?? null,
        ];

        $starClickId = trim($r['star_click_id'] ?? '');

        if (empty($starClickId) || $starClickId === '-') {
            
            return;
        }

        
        
        EbisPlanningOrder::updateOrCreate(
            ['star_click_id' => $starClickId],  
            $excelData                           
            
            
        );
    }
}
