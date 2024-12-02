<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_Bidang extends Model
{
    protected $table = 'bidang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];
}
