<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistribusiBarang extends Model
{
    protected $table = 'distribusi_barang';

    protected $fillable = [
        'barang_id',
        'cabang_id',
        'jumlah',
        'tanggal_distribusi',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal_distribusi' => 'date',
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
}

