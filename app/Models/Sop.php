<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sop extends Model
{
    protected $table = 'sops';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'nomor_sk',
        'tahun',
        'hasil_monitoring',
        'tahun_perubahan',
        'keterangan',
        'file_sk',
    ];
    public function subBidang()
    {
        return $this->belongsTo(SubBidang::class, 'sub_bidang_id');
    }


}
