<?php

namespace App\Helpers;

class DropdownHelper
{
    public static function datels()
    {
        return [
            'CIREBON',
            'INDRAMAYU',
            'MAJALENGKA',
            'KUNINGAN',
            'SUBANG'
        ];
    }

    public static function stos()
    {
        return [
          
            'JBN','JWG','KAD',
            'CKC','KRA','KYM','KNG','LGJ',
            'LSR','LOS','PAB','PTR',
            'PLD','RGA','SDU','SUB','JCG',
            'PMN','PGD','KIA','CAS'
        ];
    }

    public static function mitras()
    {
        return [
            'PT UPAYA TEKNIK',
            'PT SARANA MITRA PERSADA',
            'PT LINEA',
            'PT TRIPOLA'
        ];
    }

    public static function getDynamicFilters()
    {
        return \Illuminate\Support\Facades\Cache::remember('kpro_dynamic_filters', 300, function () {
            return [
                'starclicks' => [],
                'nama_customers' => [],
                'stos' => \App\Models\MasterSto::orderBy('nama_sto')->pluck('nama_sto'),
                'datels' => \App\Models\MasterDatel::orderBy('nama_datel')->pluck('nama_datel'),
                'progresses' => \App\Models\EbisManualInput::select('progres')->whereNotNull('progres')->where('progres', '!=', '')->distinct()->orderBy('progres')->pluck('progres'),
                'status_orders' => \App\Models\EbisPlanningOrder::select('status_order')->whereNotNull('status_order')->distinct()->pluck('status_order'),
                'tipe_desains' => \App\Models\EbisPlanningOrder::select('tipe_desain')->whereNotNull('tipe_desain')->distinct()->pluck('tipe_desain'),
                'jenis_programs' => \App\Models\EbisPlanningOrder::select('jenis_program')->whereNotNull('jenis_program')->distinct()->pluck('jenis_program'),
                'cfus' => \App\Models\EbisPlanningOrder::select('cfu')->whereNotNull('cfu')->where('cfu', '!=', '')->distinct()->orderBy('cfu')->pluck('cfu'),
                'status_proyeks' => \App\Models\EbisPlanningOrder::select('status_proyek')->whereNotNull('status_proyek')->where('status_proyek', '!=', '')->distinct()->orderBy('status_proyek')->pluck('status_proyek'),
                'nomor_batches' => \App\Models\EbisManualInput::select('nomor_batch')->whereNotNull('nomor_batch')->where('nomor_batch', '!=', '')->distinct()->orderBy('nomor_batch')->pluck('nomor_batch'),
            ];
        });
    }
}

