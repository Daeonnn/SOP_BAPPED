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
}
