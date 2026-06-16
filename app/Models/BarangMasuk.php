<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuks';

    protected $fillable = [
        'barang_id',
        'tanggal_masuk',
        'qty_masuk',
        'supplier',
        'lokasi_rak',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'qty_masuk' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
