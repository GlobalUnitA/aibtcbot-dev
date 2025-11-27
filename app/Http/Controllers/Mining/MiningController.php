<?php

namespace App\Http\Controllers\Mining;


use App\Models\Asset;
use App\Models\AssetTransfer;
use App\Models\Income;
use App\Models\IncomeAccumulation;
use App\Models\Mining;
use App\Models\MiningProduct;
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
        $Mining = MiningProduct::where('coin_id', $request->coin)
            ->get();

        return response()->json($Mining->toArray());
    }

    public function list()
    {
        $user = auth()->user();
        $minings = Mining::where('member_id', $user->member->id)->get();

        return view('mining.list', compact('minings'));
    }

    public function confirm($id)
    {
        $user = auth()->user();

        $product = MiningProduct::find($id);

        $asset = Asset::where('member_id', $user->member->id)
            ->where('coin_id', $product->coin_id)
            ->first();

        $balance = $asset->balance;

        $date = $this->getMiningDate($product);

        return view('mining.confirm', compact('product', 'date', 'balance'));
    }

    public function store(Request $request)
    {

        $user = auth()->user();
        $product = MiningProduct::find($request->product_id);
        $max_amount = optional(MiningPolicy::first())->max_entry_amount ?? 0;

        $asset = Asset::where('member_id', $user->member->id)->where('coin_id', $product->coin_id)->first();
        $income = Income::where('member_id', $user->member->id)->where('coin_id', $product->coin_id)->first();
        $sum_entry_amount = Mining::where('member_id', $user->member->id)->sum('entry_amount');

        if ($asset->balance < $request->entry_amount) {
            return response()->json([
                'status' => 'error',
                'message' =>  __('asset.lack_balance_notice'),
            ]);
        }

        if ($sum_entry_amount + $request->entry_amount > $max_amount) {
            return response()->json([
                'status' => 'error',
                'message' =>  __('mining.max_mining_amount_notice'),
            ]);
        }

        DB::beginTransaction();

        try {

            $date = $this->getMiningDate($product);

            $mining = Mining::create([
                'member_id' => $user->member->id,
                'asset_id' => $asset->id,
                'income_id' => $income->id,
                'product_id' => $product->id,
                'entry_amount' => $request->entry_amount,
                'reward_count' => 0,
                'reward_limit' => $product->reward_limit,
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

            IncomeAccumulation::firstOrCreate(
                [
                    'income_id'  => $income->id,
                ],
                [
                    'product_id' => $product->id,
                    'next_target_amount' => $product->avatar_target_amount,
                ]
            );

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

    private function getMiningDate($product)
    {
        $start = Carbon::today()->addDays($product->waiting_period+1);
        return [
            'start' => $start,
        ];
    }

}
