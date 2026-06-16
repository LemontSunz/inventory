<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IncomingGoods;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function incomingGoods()
    {
        return $this->hasMany(IncomingGoods::class);
    }
}
