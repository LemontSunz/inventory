<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Driver;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';

    protected $fillable = [
        'kode_kendaraan',
        'nama_kendaraan',
        'jenis_kendaraan',
        'plat_nomor',
        'kapasitas_muatan',
        'kilometer',
        'tahun_pembuatan',
        'warna',
        'status',
        'catatan',
    ];

    public const STATUS_SIAP = 'Siap';
    public const STATUS_PERAWATAN = 'Perawatan';
    public const STATUS_BERTUGAS = 'Dalam Perjalanan';

    public const JENIS_PICKUP = 'Pickup';
    public const JENIS_VAN = 'Van';
    public const JENIS_CDD = 'CDD';
    public const JENIS_FUSO = 'Fuso';
    public const JENIS_TRAILER = 'Trailer';
    public const JENIS_MOTOR = 'Motor';
    public const JENIS_LAINNYA = 'Lainnya';

    public static function statuses(): array
    {
        return [
            self::STATUS_SIAP,
            self::STATUS_PERAWATAN,
            self::STATUS_BERTUGAS,
        ];
    }

    public static function jenisKendaraan(): array
    {
        return [
            self::JENIS_PICKUP,
            self::JENIS_VAN,
            self::JENIS_CDD,
            self::JENIS_FUSO,
            self::JENIS_TRAILER,
            self::JENIS_MOTOR,
            self::JENIS_LAINNYA,
        ];
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class, 'kendaraan_id');
    }

    public static function statusStyles(): array
    {
        return [
            self::STATUS_SIAP => [
                'bg' => 'bg-emerald-100',
                'text' => 'text-emerald-700',
                'dot' => 'bg-emerald-500',
            ],
            self::STATUS_PERAWATAN => [
                'bg' => 'bg-amber-100',
                'text' => 'text-amber-700',
                'dot' => 'bg-amber-500',
            ],
            self::STATUS_BERTUGAS => [
                'bg' => 'bg-blue-100',
                'text' => 'text-blue-700',
                'dot' => 'bg-blue-500',
            ],
        ];
    }

    public static function generateCode(): string
    {
        $last = self::orderBy('id', 'desc')->first();

        if (! $last) {
            return 'KND0001';
        }

        if (preg_match('/KND(\d+)/', $last->kode_kendaraan, $matches)) {
            $next = (int) $matches[1] + 1;
            return 'KND' . str_pad($next, 4, '0', STR_PAD_LEFT);
        }

        return 'KND0001';
    }
}
