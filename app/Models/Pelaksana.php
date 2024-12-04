<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaksana extends Model
{
    use HasFactory;

    protected $table = 'pelaksana';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'cover_sop_id'];

    public function coverSop()
    {
        return $this->belongsTo(CoverSop::class);
    }

}
