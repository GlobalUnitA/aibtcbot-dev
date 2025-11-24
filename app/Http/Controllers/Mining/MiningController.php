<?php

namespace App\Http\Controllers\Mining;


use App\Models\Asset;
use App\Models\AssetTransfer;
use App\Models\Income;
use App\Models\Marketing;
use App\Models\Mining;
use App\Models\MiningPolicy;
use App\Http\Controllers\Controller;
use App\Services\BonusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MiningController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $assets = Asset::where('member_id', $user->member->id)
            ->whereHas('coin', function ($query) {
                $query->where('is_mining', 'y');
            })
            ->get();

        return view('mining.mining', compact( 'assets'));
    }

    public function data(Request $request)
    {
        $Mining = MiningPolicy::where('coin_id', $request->coin)
            ->get();

        return response()->json($Mining->toArray());
    }

    public function list()
    {
        $minings = Mining::where('user_id', auth()->id())->get();

        return view('mining.list', compact('minings'));
    }

    public function confirm($id)
    {
        $user = auth()->user();

        $mining = MiningPolicy::find($id);

        $asset = Asset::where('member_id', $user->member->id)
            ->where('coin_id', $mining->coin_id)
            ->first();

        $balance = $asset->balance;

        $date = $this->getMiningDate($mining);

        return view('mining.confirm', compact( 'mining', 'date', 'balance'));
    }

    public function store(Request $request)
    {

        $user = auth()->user();
        $policy = MiningPolicy::find($request->policy);
        $max_amount = 100;

        $asset = Asset::where('member_id', $user->member->id)->where('coin_id', $policy->coin_id)->first();
        $income = Income::where('member_id', $user->member->id)->where('coin_id', $policy->coin_id)->first();
        $sum_entry_amount = Mining::where('user_id', $user->id)->sum('entry_amount');

        if ($asset->balance < $request->entry_amount) {
            return response()->json([
                'status' => 'error',
                'message' =>  __('asset.lack_balance_notice'),
            ]);
        }

        if ($sum_entry_amount + $request->entry_amount >= $max_amount) {
            return response()->json([
                'status' => 'error',
                'message' =>  __('mining.max_mining_amount_notice'),
            ]);
        }

        DB::beginTransaction();

        try {

            $date = $this->getMiningDate($policy);

            $mining = Mining::create([
                'user_id' => $user->id,
                'asset_id' => $asset->id,
                'income_id' => $income->id,
                'policy_id' => $policy->id,
                'entry_amount' => $request->entry_amount,
                'reward_count' => 0,
                'reward_limit' => $policy->reward_limit,
                'started_at' => $date['start'],
            ]);

            AssetTransfer::create([
                'member_id' => $user->member->id,
                'asset_id' => $asset->id,
                'type' => 'mining',
                'status' => 'completed',
                'amount' => $request->entry_amount,
                'actual_amount' => $request->entry_amount,
                'before_balance' => $asset->balance,
                'after_balance' => $asset->balance - $request->entry_amount,
            ]);

            $asset->update([
                'balance' => $asset->balance - $request->entry_amount
            ]);

            $service = new BonusService();
            $service->referralBonus($mining);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => __('mining.mining_success_notice'),
                'url' => route('home'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' =>  $e->getMessage(),
            ]);

        }

    }

    private function getMiningDate($policy)
    {
        $start = Carbon::today()->addDays($policy->waiting_period+1);
        return [
            'start' => $start,
        ];
    }

}
