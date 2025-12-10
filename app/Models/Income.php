<?php

namespace App\Models;

use App\Traits\TruncatesDecimals;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;
use Carbon\Carbon;

class Income extends Model
{
    use HasFactory, TruncatesDecimals;

    protected $fillable = [
        'member_id',
        'coin_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:9',
    ];

     protected $appends = [
        'encrypted_id',
        'fee_rate',
        'tax_rate',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }

    public function transfers()
    {
        return $this->hasMany(IncomeTransfer::class, 'income_id', 'id');
    }

    public function accumulation()
    {
        return $this->hasOne(IncomeAccumulation::class, 'income_id', 'id');
    }

    public function getEncryptedIdAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function getFeeRateAttribute()
    {
        $policy = AssetPolicy::first();

        if (!$policy) {
            return 0;
        }

        return $policy->fee_rate;
    }

    public function getTaxRateAttribute()
    {
        $policy = AssetPolicy::first();

        if (!$policy) return 0;

        return $policy->tax_rate;
    }

    public function calculateWithdrawableAmount()
    {
        if (!$this->accumulation) return 0;

        $product = $this->accumulation->product;
        if (!$product) return 0;

        $base = floatval($product->avatar_target_amount - $product->avatar_cost);
        $accumulated_profit = $this->transfers()
            ->where('type', 'referral_bonus')
            ->where('status', 'completed')
            ->sum('amount');
        $accumulated_withdrawn = $this->transfers()
            ->where('type', 'withdrawal')
            ->where('status', 'completed')
            ->sum('amount');

        $int_part = intdiv($accumulated_profit, $product->avatar_target_amount);
        $mod_part = $accumulated_profit % $product->avatar_target_amount;

        $min_part = min($base, $mod_part);
        $withdrawable_amount = max(0, ($base * $int_part) + $min_part - $accumulated_withdrawn);

        return min($withdrawable_amount, $this->balance);
    }


    public function getIncomeInfo()
    {
        $incomeTransfers = IncomeTransfer::where('income_id', $this->id)->get();

        $deposits =  $incomeTransfers->where('type', 'deposit')->where('status', 'completed');
        $deposit_total = $deposits->sum('amount');

        $withdrawals = $incomeTransfers->where('type', 'withdrawal')->where('status', 'completed');
        $withdrawal_total = $withdrawals->sum('amount');

        $self_profits = $incomeTransfers->where('type', 'trading_profit')->where('status', 'completed');
        $self_total = $self_profits->sum('amount');

        $referral_bonus = $incomeTransfers->where('type', 'referral_bonus')->where('status', 'completed');
        $referral_bonus_total = $referral_bonus->sum('amount');

        $referral_matching = $incomeTransfers->where('type', 'referral_matching')->where('status', 'completed');
        $referral_matching_total = $referral_matching->sum('amount');

        $rank_bonus = $incomeTransfers->where('type', 'rank_bonus')->where('status', 'completed');
        $rank_bonus_total = $rank_bonus->sum('amount');

        $avatar_cost = $incomeTransfers->where('type', 'avatar_cost')->where('status', 'completed');
        $avatar_cost_total = abs($avatar_cost->sum('amount'));

        return [
            'encrypted_id' => $this->encrypted_id,
            'coin_name' => $this->coin->name,
            'balance' => $this->balance,
            'profit' => $self_total,
            'referral_bonus' => $referral_bonus_total,
            'referral_matching' => $referral_matching_total,
            'rank_bonus' => $rank_bonus_total,
            'deposit_total' => $deposit_total,
            'withdrawal_total' => $withdrawal_total,
            'avatar_cost_total' => $avatar_cost_total,
        ];
    }

}
