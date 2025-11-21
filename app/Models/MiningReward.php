<?php

namespace App\Models;

use App\Services\BonusService;
use App\Services\IncomeProcessService;
use App\Traits\TruncatesDecimals;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MiningReward extends Model
{
    use HasFactory, TruncatesDecimals;

    protected $fillable = [
        'user_id',
        'mining_id',
        'reward',
        'reward_date',
    ];

    protected $casts = [
        'reward' => 'decimal:9',
    ];

    public function getStatusTextAttribute()
    {
        return '지급 완료';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mining()
    {
        return $this->belongsTo(Mining::class, 'mining_id', 'id');
    }
}
