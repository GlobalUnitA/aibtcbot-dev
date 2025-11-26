<?php

namespace App\Http\Controllers\Profile;

use App\Models\Asset;
use App\Models\Coin;
use App\Models\Income;
use App\Models\Mining;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $data = $this->getDashboardData();

        return view('profile.dashboard', compact('data'));

    }

    private function getDashboardData()
    {

        $user = auth()->user();
        $grade = $user->member->grade->name;

        $children = $user->member->getChildrenTree();
        $avatars = $user->avatars;

        $all_count = collect($children)->flatten(1)->count();
        $referral_count = $user->member->referrals->count();
        $group_sales = $user->member->getGroupSales();

        $minings = Mining::where('member_id', $user->member->id)->get();
        $coins = Coin::all();

        $total_node_amount = $minings->sum('node_amount');
        $total_staking = [];
        $total_reward = [];

        foreach ($coins as $coin) {
            $total_staking[$coin->code] = 0;
            $total_reward[$coin->code] = 0;
        }

        foreach ($minings as $mining) {

            $income = Income::find($mining->income_id);
            foreach ($coins as $coin) {
                if ($income->coin_id === $coin->id) {
                    foreach ($mining->rewards as $reward) {
                        $total_reward[$coin->code] += $reward->sum('reward');
                    }
                }
            }
        }

        $total_staking = array_filter($total_staking, fn($v) => $v != 0);
        $total_reward = array_filter($total_reward, fn($v) => $v != 0);

        return [
            'grade' => $grade,
            'all_count' => $all_count,
            'referral_count' => $referral_count,
            'group_sales' => $group_sales,
            'total_node_amount' => $total_node_amount,
            'total_reward' => $total_reward,
            'avatars' => $avatars,
        ];
    }
}
