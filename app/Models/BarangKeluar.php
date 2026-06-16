<?php

namespace App\Models;

use App\Models\Driver;
use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'barang_id',
        'cabang_id',
        'driver_id',
        'kendaraan_id',
        'jumlah_keluar',
        'tanggal_keluar',
        'keterangan',
    ];

    protected $casts = [
        'jumlah_keluar' => 'integer',
        'tanggal_keluar' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}

