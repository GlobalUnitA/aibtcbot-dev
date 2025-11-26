<?php

namespace App\Models;

use App\Traits\TruncatesDecimals;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class MiningPolicy extends Model
{
    protected $fillable = [
        'avatar_product_id',
        'max_entry_amount',
    ];

    protected static $columnDescriptions = [
        'avatar_product_id' => '아바타 가입 상품',
        'max_entry_amount' => '최대 참여 금액',
    ];

    public function getColumnComment($column)
    {
        return static::$columnDescriptions[$column];
    }
}
