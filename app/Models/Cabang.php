<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Driver;

class Cabang extends Model
{
    protected $table = 'cabang';

    protected $fillable = [
        'kode_cabang',
        'nama_cabang',
        'kota',
        'alamat',
    ];

    public function drivers()
    {
        return $this->hasMany(Driver::class, 'cabang_id');
    }
}

