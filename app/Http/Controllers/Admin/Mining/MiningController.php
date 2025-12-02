<?php

namespace App\Http\Controllers\Admin\Mining;

use App\Models\Mining;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MiningController extends Controller
{
    public function __construct()
    {

    }

    public function list(Request $request)
    {
        $list = Mining::with(['member.user', 'member.avatar'])

        ->when($request->filled('category') && $request->filled('keyword'), function ($query) use ($request) {
            switch ($request->category) {
                case 'uid':
                    $query->whereHas('member.user', function ($query) use ($request) {
                        $query->where('users.id', 'LIKE', '%' . $request->keyword . '%');
                    });
                    break;
                case 'aid':
                    $query->whereHas('member.avatar', function ($query) use ($request) {
                        $query->where('avatars.id', 'LIKE', '%' . $request->keyword . '%');
                    });
                    break;
                case 'account':
                    $query->whereHas('member.user', function ($query) use ($request) {
                        $query->where('users.account', 'LIKE', '%' . $request->keyword . '%');
                    });
                    break;
                case 'name':
                    $query->whereHas('member.user', function ($query) use ($request) {
                        $query->where('users.name', 'LIKE', '%' . $request->keyword . '%');
                    });
                    break;
            }
        })
        ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();

            $query->whereBetween('mining.created_at', [$start, $end]);
        })
        ->where('status', $request->status)
        ->latest()
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('admin.mining.list', compact('list'));
    }

    public function view(Request $request)
    {
        $start_date = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : today()->startOfDay();

        $end_date = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : today()->endOfDay();

        $view = Mining::find($request->id);

        $rewards = $view->rewards()
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        $level_bonuses = collect();
        foreach ($rewards as $reward) {
            if ($reward->levelBonus) {
                $level_bonuses->push($reward->levelBonus);
            }
        }

        $referral_bonuses = $view->referralBonus()
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        return view('admin.mining.view', compact('view', 'rewards', 'level_bonuses', 'referral_bonuses'));
    }

}
