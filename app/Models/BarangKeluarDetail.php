<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluarDetail extends Model
{
    protected $table = 'barang_keluar_details';

    protected $fillable = [
        'barang_keluar_id',
        'barang_id',
        'jumlah_keluar',
    ];

    protected $casts = [
        'jumlah_keluar' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class);
    }

    public function item()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
