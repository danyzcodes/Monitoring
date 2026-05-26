<?php

namespace App\Exports;

use App\Models\EbisManualInput;
use App\Models\EbisPlanningOrder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class RekapExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $request;
    private $rowNum = 1;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = EbisManualInput::with(['planning.logs']);

        // FILTER DROPDOWN ATAS
        if ($this->request->filled('starclick')) {
            $query->where('ebis_manual_inputs.star_click_id', $this->request->starclick);
        }

        if ($this->request->filled('nama')) {
            $query->where('ebis_manual_inputs.nama_customer', 'like', '%' . $this->request->nama . '%');
        }

        if ($this->request->filled('sto')) {
            $stos = array_filter((array) $this->request->sto);
            if (!empty($stos)) $query->whereIn('ebis_manual_inputs.sto', $stos);
        }

        if ($this->request->filled('datel')) {
            $datels = array_filter((array) $this->request->datel);
            if (!empty($datels)) $query->whereIn('ebis_manual_inputs.datel', $datels);
        }

        if ($this->request->filled('progres')) {
            $progresses = array_filter((array) $this->request->progres);
            if (!empty($progresses)) $query->whereIn('ebis_manual_inputs.progres', $progresses);
        }

        if ($this->request->filled('nomor_batch')) {
            $batches = array_filter((array) $this->request->nomor_batch);
            if (!empty($batches)) $query->whereIn('ebis_manual_inputs.nomor_batch', $batches);
        }

        $hasRelFilter = $this->request->filled('status_order') || $this->request->filled('tipe_desain') || $this->request->filled('jenis_program') || $this->request->filled('cfu') || $this->request->filled('status_proyek');
        if ($hasRelFilter) {
            $query->whereHas('planning', function ($q) {
                if ($this->request->filled('status_order')) {
                    $vals = array_filter((array) $this->request->status_order);
                    if (!empty($vals)) $q->whereIn('status_order', $vals);
                }
                if ($this->request->filled('tipe_desain')) {
                    $vals = array_filter((array) $this->request->tipe_desain);
                    if (!empty($vals)) $q->whereIn('tipe_desain', $vals);
                }
                if ($this->request->filled('jenis_program')) {
                    $vals = array_filter((array) $this->request->jenis_program);
                    if (!empty($vals)) $q->whereIn('jenis_program', $vals);
                }
                if ($this->request->filled('cfu')) {
                    $vals = array_filter((array) $this->request->cfu);
                    if (!empty($vals)) $q->whereIn('cfu', $vals);
                }
                if ($this->request->filled('status_proyek')) {
                    $vals = array_filter((array) $this->request->status_proyek);
                    if (!empty($vals)) $q->whereIn('status_proyek', $vals);
                }
            });
        }

        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('ebis_manual_inputs.created_at', [
                $this->request->start_date . ' 00:00:00',
                $this->request->end_date . ' 23:59:59'
            ]);
        } elseif ($this->request->filled('start_date')) {
            $query->where('ebis_manual_inputs.created_at', '>=', $this->request->start_date . ' 00:00:00');
        } elseif ($this->request->filled('end_date')) {
            $query->where('ebis_manual_inputs.created_at', '<=', $this->request->end_date . ' 23:59:59');
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            if (str_contains($search, ',')) {
                $values = array_filter(array_map('trim', explode(',', $search)));
                $query->where(function ($q) use ($values) {
                    $q->whereIn('ebis_manual_inputs.star_click_id', $values);
                    foreach ($values as $val) {
                        $q->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$val}%");
                    }
                });
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('ebis_manual_inputs.star_click_id', 'like', "%{$search}%")
                      ->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$search}%")
                      ->orWhere('ebis_manual_inputs.nde_jt', 'like', "%{$search}%")
                      ->orWhere('ebis_manual_inputs.sto', 'like', "%{$search}%");
                });
            }
        }

        $key = $this->request->filter_key;
        $values = array_filter(array_map('trim', explode(',', $this->request->filter_values ?? '')));

        if ($key && !empty($values)) {
            $query->where(function ($q) use ($key, $values) {
                foreach ($values as $val) {
                    if ($key === 'star_click_id') {
                        $q->orWhere('ebis_manual_inputs.star_click_id', $val);
                    } elseif ($key === 'sto') {
                        $q->orWhere('ebis_manual_inputs.sto', 'like', "%{$val}%");
                    } elseif ($key === 'nama_customer') {
                        $q->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$val}%");
                    }

                    if (in_array($key, ['ihld_lop_id', 'status_order', 'tipe_desain', 'jenis_program'])) {
                        $q->orWhereHas('planning', function ($p) use ($key, $val) {
                            if ($key === 'ihld_lop_id') {
                                    $p->where($key, $val);
                            } else {
                                    $p->where($key, 'like', "%{$val}%");
                            }
                        });
                    }
                }
            });
        }

        return $query
            ->leftJoin('ebis_planning_orders', 'ebis_manual_inputs.star_click_id', '=', 'ebis_planning_orders.star_click_id')
            ->select('ebis_manual_inputs.*')
            ->orderBy('ebis_planning_orders.id', 'desc');
    }

    public function headings(): array
    {
        return [
            'NDE JT',
            'Starclick ID',
            'Nama',
            'Nama Mitra',
            'Alamat',
            'Telepon',
            'Tikor',
            'Datel',
            'STO',
            'Status Alokasi',
            'Status Order',
            'iHLD LoP ID',
            'Tipe Desain',
            'Total BOQ',
            'Jenis Program',
            'Nama CFU',
            'Tanggal Update',
            'Catatan',
            'Usia Order',
            'Pilih Progres',
            'Durasi Progres',
            'ON DESK',
            'SURVEY',
            'PERIJINAN',
            'DRM',
            'APPROVED BY EBIS',
            'MATDEV',
            'INSTALASI',
            'SELESAI FISIK',
            'GOLIVE',
            'PS',
            'KENDALA',
            'UJI TERIMA',
            'REKON',
        ];
    }

    public function map($row): array
    {
        $this->rowNum++;
        $rowNum = $this->rowNum;

        $planning = $row->planning;
        $date = optional($planning)->tanggal_update_progres ?? $row->tanggal_update_progres;

        $baseData = [
            $row->nde_jt ?? '-',
            $row->star_click_id ?? '-',
            $row->nama_customer ?? '-',
            $row->nama_mitra ?? '-',
            $row->alamat_pelanggan ?? '-',
            $row->telepon_pelanggan ?? '-',
            $row->tikor_pelanggan ?? '-',
            $row->datel ?? '-',
            $row->sto ?? '-',
            optional($planning)->status_alokasi_alpro ?? '-',
            optional($planning)->status_order ?? '-',
            optional($planning)->ihld_lop_id ?? '-',
            optional($planning)->tipe_desain ?? '-',
            optional($planning)->total_boq ? number_format(optional($planning)->total_boq, 0, ',', '.') : '-',
            optional($planning)->jenis_program ?? '-',
            optional($planning)->nama_cfu ?? '-',
            $date ? Carbon::parse($date)->format('d-m-Y H:i') : '-',
            $row->keterangan ?? '-',
        ];

        $stages = [
            'ON DESK',
            'SURVEY',
            'PERIJINAN',
            'DRM',
            'APPROVED BY EBIS',
            'MATDEV',
            'INSTALASI',
            'SELESAI FISIK',
            'GOLIVE',
            'PS',
            'KENDALA',
            'UJI TERIMA',
            'REKON'
        ];

        $stageDates = [];
        $logs = optional($planning)->logs ?? collect();
        foreach ($logs as $log) {
            $stage = strtoupper(trim($log->progres));
            $logDate = Carbon::parse($log->created_at);
            if (!isset($stageDates[$stage])) {
                $stageDates[$stage] = $logDate;
            } else {
                if ($logDate->lt($stageDates[$stage])) {
                    $stageDates[$stage] = $logDate;
                }
            }
        }

        // Fallback: If current progress exists but log is missing
        $currentStage = strtoupper(trim($row->progres ?? optional($planning)->progres ?? ''));
        $currentDate = $row->tanggal_update_progres ?? optional($planning)->tanggal_update_progres;
        if ($currentStage && !isset($stageDates[$currentStage]) && $currentDate) {
            $stageDates[$currentStage] = Carbon::parse($currentDate);
        }

        // Calculate durations from ON DESK for each stage
        $onDeskDate = $stageDates['ON DESK'] ?? null;
        
        $durationsData = [];
        foreach ($stages as $stageName) {
            if ($stageName === 'ON DESK') {
                $durationsData[] = $onDeskDate ? '0 hari' : '-';
            } else {
                $dateObj = $stageDates[$stageName] ?? null;
                if ($onDeskDate && $dateObj) {
                    $diffInMinutes = abs($onDeskDate->diffInMinutes($dateObj, false));
                    $days = floor($diffInMinutes / 1440);
                    $hours = round(($diffInMinutes % 1440) / 60);
                    if ($hours >= 24) {
                        $days += 1;
                        $hours -= 24;
                    }
                    
                    $parts = [];
                    if ($days > 0) {
                        $parts[] = $days . " hari";
                    }
                    if ($hours > 0) {
                        $parts[] = $hours . " jam";
                    }
                    
                    $durationsData[] = !empty($parts) ? implode(' ', $parts) : '0 jam';
                } else {
                    $durationsData[] = '-';
                }
            }
        }

        // Calculate Usia Order from created_at
        $createdAt = $row->created_at ? Carbon::parse($row->created_at) : null;
        if ($createdAt) {
            $diffCreated = abs($createdAt->diffInMinutes(now(), false));
            $cDays = floor($diffCreated / 1440);
            $cHours = round(($diffCreated % 1440) / 60);
            if ($cHours >= 24) {
                $cDays += 1;
                $cHours -= 24;
            }
            $cParts = [];
            if ($cDays > 0) {
                $cParts[] = $cDays . " hari";
            }
            if ($cHours > 0) {
                $cParts[] = $cHours . " jam";
            }
            $usiaOrder = !empty($cParts) ? implode(' ', $cParts) : '0 jam';
        } else {
            $usiaOrder = '-';
        }

        // Formula for Column U:
        $formula = "=IFERROR(INDEX(V" . $rowNum . ":AH" . $rowNum . ", MATCH(T" . $rowNum . ", \$V\$1:\$AH\$1, 0)), \"-\")";

        // We set 'SURVEY' as the default selection in Column T
        $defaultSelection = 'SURVEY';

        return array_merge($baseData, [$usiaOrder, $defaultSelection, $formula], $durationsData);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                for ($row = 2; $row <= $highestRow; $row++) {
                    $validation = $sheet->getCell("T$row")->getDataValidation();
                    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(true);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);

                    $validation->setFormula1('"ON DESK,SURVEY,PERIJINAN,DRM,APPROVED BY EBIS,MATDEV,INSTALASI,SELESAI FISIK,GOLIVE,PS,KENDALA,UJI TERIMA,REKON"');
                }

                // Hide source data columns V to AH
                foreach (range('V', 'Z') as $col) {
                    $sheet->getColumnDimension($col)->setVisible(false);
                }
                foreach (['AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH'] as $col) {
                    $sheet->getColumnDimension($col)->setVisible(false);
                }
            }
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
            'S' => [
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            'T' => [
                'font' => ['italic' => true, 'color' => ['rgb' => '1D4ED8']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            'U' => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ]
        ];
    }
}
