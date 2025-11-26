<?php

namespace App\Models;

use App\Traits\TruncatesDecimals;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiningProductTranslation extends Model
{
    use HasFactory, TruncatesDecimals;

    protected $fillable = [
        'product_id',
        'locale',
        'name',
        'memo',
    ];

    public function product()
    {
        return $this->belongsTo(MiningProduct::class, 'product_id', 'id');
    }
}
