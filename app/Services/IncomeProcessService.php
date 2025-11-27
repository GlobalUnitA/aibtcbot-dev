<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Income;
use App\Models\IncomeAccumulation;
use App\Models\IncomeTransfer;
use App\Models\MiningProduct;
use App\Services\MemberService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncomeProcessService
{
    /**
     *
     * @param Income $income
     * @param float $amount
     */
    public function addProfitAndProcess(Income $income, float $amount)
    {
        DB::transaction(function () use ($income, $amount) {

            $accumulation = IncomeAccumulation::where('income_id', $income->id)->first();

            if (!$accumulation) return;

            $accumulation->accumulated_amount += $amount;
            $accumulation->save();

            $this->processPolicyCondition($accumulation, $income);

        });
    }

    /**
     */
    protected function processPolicyCondition(IncomeAccumulation $accumulation, Income $income)
    {
        $service = new MemberService();
        $product = MiningProduct::find($accumulation->product_id);
        $member = Member::find($income->member_id);

        while ($accumulation->accumulated_amount >= $accumulation->next_target_amount) {

            Log::channel('avatar')->info('Start to add avatar', [
                'member_id' => $member->id,
                'accumulated_amount' => $accumulation->accumulated_amount,
                'next_target_amount' => $accumulation->next_target_amount,
                'avatar_count' => $product->avatar_count,
            ]);

            $accumulation->accumulated_amount -= $product->avatar_cost;
            $accumulation->next_target_amount = $accumulation->accumulated_amount + $product->avatar_target_amount;
            $accumulation->save();

            $income->balance -= $product->avatar_cost;
            $income->save();

            IncomeTransfer::create([
                'member_id' => $member->id,
                'income_id' => $income->id,
                'type' => 'avatar_cost',
                'status' => 'completed',
                'amount' => -$product->avatar_cost,
                'actual_amount' => -$product->avatar_cost,
                'before_balance' => $income->balance,
                'after_balance' => $income->balance - $product->avatar_cost,
            ]);

            for ($i = 0; $i < $product->avatar_count; $i++) {
                $service->addAvatar($member);
                Log::channel('avatar')->info('Success to add avatar', ['member_id' => $member->id, 'count' => $i+1]);
            }
        }
    }
}
