<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';

    protected $fillable = [
        'driver_code',
        'name',
        'phone',
        
        'license_class',
        'license_expiry_date',
        
        'status',
        'notes',
    ];

    protected $casts = [
        'license_expiry_date' => 'date',
    ];

    public const STATUS_AVAILABLE = 'Tersedia';
    public const STATUS_ON_ROUTE = 'Sedang Bertugas';
    public const STATUS_INACTIVE = 'Tidak Aktif';

    public const LICENSE_CLASS_A = 'SIM A';
    public const LICENSE_CLASS_B1 = 'SIM B1';
    public const LICENSE_CLASS_B2 = 'SIM B2';
    public const LICENSE_CLASS_C = 'SIM C';

    public static function statuses(): array
    {
        return [
            self::STATUS_AVAILABLE,
            self::STATUS_ON_ROUTE,
            self::STATUS_INACTIVE,
        ];
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    public static function licenseClasses(): array
    {
        return [
            self::LICENSE_CLASS_A,
            self::LICENSE_CLASS_B1,
            self::LICENSE_CLASS_B2,
            self::LICENSE_CLASS_C,
        ];
    }

    public static function statusStyles(): array
    {
        return [
            self::STATUS_AVAILABLE => [
                'bg' => 'bg-cyan-100',
                'text' => 'text-cyan-700',
                'dot' => 'bg-cyan-500',
            ],
            self::STATUS_ON_ROUTE => [
                'bg' => 'bg-amber-100',
                'text' => 'text-amber-700',
                'dot' => 'bg-amber-500',
            ],
            self::STATUS_INACTIVE => [
                'bg' => 'bg-rose-100',
                'text' => 'text-rose-700',
                'dot' => 'bg-rose-500',
            ],
        ];
    }

    public static function generateCode(): string
    {
        $last = self::orderBy('id', 'desc')->first();

        if (! $last) {
            return 'DRV0001';
        }

        if (preg_match('/DRV(\d+)/', $last->driver_code, $matches)) {
            $next = (int) $matches[1] + 1;
            return 'DRV' . str_pad($next, 4, '0', STR_PAD_LEFT);
        }

        return 'DRV0001';
    }
}
