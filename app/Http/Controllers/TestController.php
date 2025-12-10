<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Member;
use App\Models\Mining;
use App\Models\MiningReward;
use App\Models\MiningPolicy;
use App\Models\User;
use App\Models\KakaoApi;
use App\Models\UserOtp;
use App\Models\Admin;
use App\Models\AdminOtp;
use App\Models\Asset;
use App\Models\AssetPolicy;
use App\Models\AssetTransfer;
use App\Models\Income;
use App\Models\IncomeTransfer;
use App\Models\ReferralMatchingPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use PragmaRX\Google2FA\Google2FA;
use App\Services\MemberService;
use Carbon\Carbon;

class TestController extends Controller
{
    protected $kakaoApi;

    public function __construct()
    {
        $this->kakaoApi = new KakaoApi();;
    }

   public function index()
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();
        $income = $member->incomes->where('coin_id', '1')->first();

        $product = $income->accumulation->product;

        $base = $product->avatar_target_amount - $product->avatar_cost;

        dump('base : ', $base);
        $accumulated_profit = $income->transfers()
            ->where('type', 'referral_bonus')
            ->where('status', 'completed')
            ->sum('amount');

        dump('accumulated_profit : ', $accumulated_profit);
        $accumulated_withdrawn = $income->transfers()
            ->where('type', 'withdrawal')
            ->where('status', 'completed')
            ->sum('amount');

        dump('accumulated_withdrawn : ', $accumulated_withdrawn);

        $int_part = intdiv($accumulated_profit, $product->avatar_target_amount);
        dump('int_part : ', $int_part);

        $mod_part = $accumulated_profit % $product->avatar_target_amount;
        dump('mod_part : ', $mod_part);

        $min_part = min($base, $mod_part);
        dump('min_part : ', $min_part);

        $withdrawable_amount = max(0, ($base * $int_part) + $min_part - $accumulated_withdrawn);
        dump('withdrawable_amount : ', $withdrawable_amount);

        dd(min($withdrawable_amount, $income->balance));
    }
}
