<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];
    public function subBidangs()
    {
        return $this->hasMany(Sub_Bidang::class, 'bidang_id');
    }
}
