<?php

namespace App\Services;

use App\Models\Income;
use App\Models\IncomeAccumulation;
use App\Models\MiningPolicy;
use App\Services\MemberService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncomeProcessService
{
    /**
     *
     * @param Income $income
     * @param MiningPolicy $policy
     * @param float $amount
     */
    public function addProfitAndProcess(Income $income, MiningPolicy $policy, float $amount)
    {
        DB::transaction(function () use ($income, $policy, $amount) {

            $income->balance += $amount;
            $income->save();

            IncomeAccumulation::firstOrCreate([
                'income_id' => $income->id,
                'mining_policy_id' => $policy->id,
                ],
                [
                'next_target_amount' => $policy->avatar_target_amount,
                ]
            );

            $accumulations = IncomeAccumulation::where('income_id', $income->id)->get();

            foreach ($accumulations as $accumulation) {
                $accumulation->accumulated_amount += $amount;
                $accumulation->save();

                $this->processPolicyCondition($accumulation, $income);
            }

        });
    }

    /**
     */
    protected function processPolicyCondition(IncomeAccumulation $accumulation, Income $income)
    {
        $service = new MemberService();
        $policy = MiningPolicy::find($accumulation->mining_policy_id);

        while ($accumulation->accumulated_amount >= $accumulation->next_target_amount) {

            Log::channel('avatar')->info('Start to add avatar', [
                'user_id' => $accumulation->income->member->user_id,
                'accumulated_amount' => $accumulation->accumulated_amount,
                'next_target_amount' => $accumulation->next_target_amount,
                'avatar_count' => $policy->avatar_count,
            ]);

            $accumulation->accumulated_amount -= $policy->avatar_cost;
            $accumulation->next_target_amount = $accumulation->accumulated_amount + $policy->avatar_target_amount;
            $accumulation->save();

            $income->balance -= $policy->avatar_cost;
            $income->save();

            for ($i = 0; $i < $policy->avatar_count; $i++) {
                $user = $income->member->user;
                $service->addAvatar($user);
                Log::channel('avatar')->info('Success to add avatar', ['user_id' => $user->id, 'count' => $i+1]);
            }
        }
    }
}
