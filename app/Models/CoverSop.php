<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverSop extends Model
{
    use HasFactory;

    protected $table = 'cover_sop';

    protected $fillable = [
        'name',
        'dasar_hukum',
        'keterkaitan',
        'peringatan',
        'no_sop',
        'tgl_pembuatan',
        'tgl_revisi',
        'tgl_aktif',
        'kualifikasi_pelaksana',
        'perlengkapan',
        'pencatatan',
        'sub_bidang_id',
        'bidang_id',
    ];

    // In CoverSop model
public function subBidang()
{
    return $this->belongsTo(Sub_Bidang::class);  // Assuming a CoverSop belongs to a SubBidang
}


    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }


    public function pelaksana()
    {
        return $this->hasMany(Pelaksana::class);
    }
}
