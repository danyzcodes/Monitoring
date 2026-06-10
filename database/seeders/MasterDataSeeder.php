<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        
        $datels = DB::table('ebis_manual_inputs')
            ->select('datel')
            ->whereNotNull('datel')
            ->distinct()
            ->pluck('datel');

        foreach ($datels as $datel) {
            DB::table('master_datels')->updateOrInsert(
                ['nama_datel' => trim($datel)],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        
        $stos = DB::table('ebis_manual_inputs')
            ->select('sto')
            ->whereNotNull('sto')
            ->distinct()
            ->pluck('sto');

        foreach ($stos as $sto) {
            DB::table('master_stos')->updateOrInsert(
                ['nama_sto' => trim($sto)],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        
        $mitras = DB::table('ebis_manual_inputs')
            ->select('nama_mitra')
            ->whereNotNull('nama_mitra')
            ->distinct()
            ->pluck('nama_mitra');

        foreach ($mitras as $mitra) {
            DB::table('master_mitras')->updateOrInsert(
                ['nama_mitra' => trim($mitra)],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}