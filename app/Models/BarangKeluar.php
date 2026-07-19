<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\BarangKeluarDetail;
use App\Models\Cabang;
use App\Models\Driver;
use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'nomor_pengiriman',
        'barang_id',
        'cabang_id',
        'driver_id',
        'kendaraan_id',
        'jumlah_keluar',
        'tanggal_keluar',
        'keterangan',
        'status',
    ];

    public const STATUS_DALAM_PERJALANAN = 'Dalam Perjalanan';
    public const STATUS_TERKIRIM = 'Terkirim';

    public static function statuses(): array
    {
        return [
            self::STATUS_DALAM_PERJALANAN,
            self::STATUS_TERKIRIM,
        ];
    }

    public static function statusStyles(): array
    {
        return [
            self::STATUS_DALAM_PERJALANAN => [
                'bg' => 'bg-blue-100',
                'text' => 'text-blue-700',
            ],
            self::STATUS_TERKIRIM => [
                'bg' => 'bg-emerald-100',
                'text' => 'text-emerald-700',
            ],
            'Draft' => [
                'bg' => 'bg-slate-100',
                'text' => 'text-slate-700',
            ],
            'Dibatalkan' => [
                'bg' => 'bg-red-100',
                'text' => 'text-red-700',
            ],
        ];
    }

    protected $casts = [
        'jumlah_keluar' => 'integer',
        'tanggal_keluar' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(BarangKeluarDetail::class, 'barang_keluar_id');
    }

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

    public function markAsDelivered()
    {
        if ($this->status !== self::STATUS_DALAM_PERJALANAN) {
            throw new \RuntimeException('Pengiriman hanya dapat diselesaikan jika status sedang Dalam Perjalanan.');
        }

        $this->update(['status' => self::STATUS_TERKIRIM]);

        if ($this->driver) {
            $this->driver->update(['status' => Driver::STATUS_AVAILABLE]);
        }

        if ($this->kendaraan) {
            $this->kendaraan->update(['status' => Kendaraan::STATUS_SIAP]);
        }

        return $this;
    }
}

