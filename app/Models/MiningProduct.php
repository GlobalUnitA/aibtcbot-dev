<?php

namespace App\Models;

use App\Traits\TruncatesDecimals;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class MiningProduct extends Model
{
    use HasFactory, TruncatesDecimals;

    protected $fillable = [
        'coin_id',
        'entry_amount',
        'reward_days',
        'reward_limit',
        'waiting_period',
        'avatar_cost',
        'avatar_count',
        'avatar_target_amount',
        'benefit_rules',
    ];

    protected $casts = [
        'benefit_rules' => 'array',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'mining_locale_name',
        'mining_locale_memo',
    ];

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }

    public function translations()
    {
        return $this->hasMany(MiningProductTranslation::class, 'product_id', 'id');
    }

    public function getMiningLocaleNameAttribute()
    {
        return optional($this->translationForLocale())->name;
    }

    public function getMiningLocaleMemoAttribute()
    {
        return optional($this->translationForLocale())->memo;
    }

    public function translationForLocale($locale = null)
    {
        $locale = $locale ?? Cookie::get('app_locale', 'en');

        if (!$this->relationLoaded('translations')) {
            $this->load('translations');
        }

        return $this->translations->firstWhere('locale', $locale);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected static $columnDescriptions = [
        'coin_id' => '참여 코인',
        'entry_amount' => '참여수량',
        'reward_days' => '채굴 가능 요일',
        'reward_limit' => '채굴 제한',
        'waiting_period' => '대기기간',
        'avatar_cost' => '아바타 생성 비용',
        'avatar_count' => '아바타 생성 개수',
        'avatar_target_amount' => '아바타 생성 누적 금액',
        'benefit_rules' => '혜택 규칙',
    ];

    public function getColumnComment($column)
    {
        return static::$columnDescriptions[$column];
    }
}
