<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbisManualInput extends Model
{
    use HasFactory;

    protected $table = 'ebis_manual_inputs';

    protected $fillable = ['nde_jt', 'star_click_id', 'nomor_batch', 'nama_customer', 'nama_mitra', 'alamat_pelanggan', 'telepon_pelanggan', 'tikor_pelanggan', 'datel', 'sto', 'link_dokumen', 'progres', 'keterangan', 'data', 'tanggal_update_progres'];

    protected $casts = [
        'data' => 'array',
    ];

    
    public function planning()
    {
        return $this->belongsTo(\App\Models\EbisPlanningOrder::class, 'star_click_id', 'star_click_id');
    }
}
