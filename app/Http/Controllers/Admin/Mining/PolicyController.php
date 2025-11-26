<?php

namespace App\Http\Controllers\Admin\Mining;

use App\Models\MiningPolicy;
use App\Models\MiningProduct;
use App\Models\PolicyModifyLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PolicyController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $policy = MiningPolicy::first();
        $products = MiningProduct::all();


        $modify_logs = PolicyModifyLog::join('mining_policies', 'mining_policies.id', '=', 'policy_modify_logs.policy_id')
            ->join('admins', 'admins.id', '=', 'policy_modify_logs.admin_id')
            ->select('admins.name', 'policy_modify_logs.*')
            ->where('policy_modify_logs.policy_type', 'mining_policies')
            ->where('mining_policies.id', $policy->id)
            ->orderBy('policy_modify_logs.created_at', 'desc')
            ->get();

        return view('admin.mining.policy', compact('policy', 'products', 'modify_logs'));

    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        try {

            $policy = MiningPolicy::findOrFail($request->id);
            $policy->update($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => '정책이 수정되었습니다.',
                'url' => route('admin.mining.policy'),
            ]);


        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to update mining policy', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => '예기치 못한 오류가 발생했습니다.',
            ]);
        }
    }

}
