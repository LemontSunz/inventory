<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use App\Models\RackLocation;
use App\Models\IncomingGoods;

class IncomingGoodsDetail extends Model
{
    protected $table = 'incoming_goods_details';

    protected $fillable = [
        'incoming_goods_id',
        'item_id',
        'quantity_received',
        'rack_location_id',
    ];

    protected $casts = [
        'quantity_received' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function incomingGoods()
    {
        return $this->belongsTo(IncomingGoods::class);
    }

    public function item()
    {
        return $this->belongsTo(Barang::class, 'item_id');
    }

    public function rackLocation()
    {
        return $this->belongsTo(RackLocation::class);
    }
}
