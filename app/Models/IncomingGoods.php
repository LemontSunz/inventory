<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\IncomingGoodsDetail;
use App\Models\User;

class IncomingGoods extends Model
{
    protected $table = 'incoming_goods';

    protected $fillable = [
        'receiving_code',
        'container_number',
        'receiving_date',
        'supplier_id',
        'delivery_order_number',
        'description',
        'created_by',
    ];

    protected $casts = [
        'receiving_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(IncomingGoodsDetail::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
