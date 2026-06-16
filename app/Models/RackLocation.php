<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IncomingGoodsDetail;

class RackLocation extends Model
{
    protected $table = 'rack_locations';

    protected $fillable = [
        'code',
        'label',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function incomingGoodsDetails()
    {
        return $this->hasMany(IncomingGoodsDetail::class);
    }
}
