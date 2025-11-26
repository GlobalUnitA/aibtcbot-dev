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
        'member_id',
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

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function mining()
    {
        return $this->belongsTo(Mining::class, 'mining_id', 'id');
    }
}
