<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Bidang extends Model
{
    use HasFactory;

    protected $table = 'sub_bidang';
    protected $fillable = ['name', 'bidang_id'];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }
}
