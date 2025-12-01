<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class IncomeAccumulation extends Authenticatable
{
    protected $fillable = [
        'income_id',
        'product_id',
        'accumulated_amount',
        'next_target_amount',
    ];

    public function income()
    {
        return $this->belongsTo(Income::class,'income_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(MiningProduct::class, 'product_id', 'id');
    }

}
