<?php

namespace App\Models;

use App\Models\IncomingGoodsDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class IncomingGoods extends Model
{
    protected $table = 'incoming_goods';

    protected $fillable = [
        'receiving_code',
        'container_number',
        'receiving_date',
        'supplier',
        'supplier_id',
        'supplier_name',
        'delivery_order_number',
        'description',
        'created_by',
    ];

    protected $casts = [
        'receiving_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(IncomingGoodsDetail::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function generateReceivingCode(): string
    {
        $lastRecord = self::select('receiving_code')
            ->whereNotNull('receiving_code')
            ->where('receiving_code', 'like', 'TRM-%')
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = 0;

        if ($lastRecord && preg_match('/(\d+)$/', $lastRecord->receiving_code, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        $nextNumber = $lastNumber + 1;

        return 'TRM-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}

