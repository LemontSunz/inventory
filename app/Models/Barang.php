<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\IncomingGoodsDetail;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'satuan',
        'stok',
        'lokasi_rak',
        'deskripsi',
    ];

    protected $casts = [
        'stok' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relasi: Barang memiliki banyak record barang masuk
     */
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    /**
     * Relasi: Barang memiliki banyak record barang keluar
     */
    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }

    public function incomingGoodsDetails()
    {
        return $this->hasMany(IncomingGoodsDetail::class, 'item_id');
    }
}
