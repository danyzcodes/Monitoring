<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbisManualInput extends Model
{
    use HasFactory;

    protected $table = 'ebis_manual_inputs';

    protected $fillable = ['user_id', 'nde_jt', 'star_click_id', 'nomor_batch', 'nama_customer', 'nama_mitra', 'alamat_pelanggan', 'telepon_pelanggan', 'tikor_pelanggan', 'datel', 'sto', 'link_dokumen', 'progres', 'keterangan', 'data', 'tanggal_update_progres'];

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function planning()
    {
        return $this->belongsTo(\App\Models\EbisPlanningOrder::class, 'star_click_id', 'star_click_id');
    }

    /**
     * Get allowed progress stages based on the current progress and commitment date.
     * Non-admin users are restricted to the current stage, the next stage (if commitment date is filled),
     * and the KENDALA stage.
     */
    public function getAllowedProgressOptions($user)
    {
        $allStages = [
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
            'UJI TERIMA',
            'REKON'
        ];

        if ($user && $user->role === 'admin') {
            return array_merge($allStages, ['KENDALA']);
        }

        $currentProgress = $this->progres;

        // If current progress is KENDALA, find the last non-KENDALA progress from logs
        if ($currentProgress === 'KENDALA') {
            $lastLog = optional($this->planning)->logs
                ? optional($this->planning)->logs->where('progres', '!=', 'KENDALA')->sortByDesc('created_at')->first()
                : null;
            $currentProgress = $lastLog ? $lastLog->progres : 'ON DESK';
        }

        $currentIndex = array_search($currentProgress, $allStages);
        if ($currentIndex === false) {
            $currentIndex = 0; // Default to ON DESK
        }

        $allowedOptions = [];
        $actualCurrent = $allStages[$currentIndex];
        $allowedOptions[] = $actualCurrent;

        $hasCommitmentDate = !empty($this->data['commitment_date']);
        if ($hasCommitmentDate && isset($allStages[$currentIndex + 1])) {
            $allowedOptions[] = $allStages[$currentIndex + 1];
        }

        $allowedOptions[] = 'KENDALA';

        return array_values(array_unique($allowedOptions));
    }
}

