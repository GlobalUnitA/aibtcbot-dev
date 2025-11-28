<?php

namespace App\Services;


use App\Models\Asset;
use App\Models\AssetTransfer;
use App\Models\Coin;
use App\Models\Income;
use App\Models\IncomeAccumulation;
use App\Models\Member;
use App\Models\Mining;
use App\Models\MiningPolicy;
use App\Models\MiningProduct;
use App\Models\User;
use App\Models\Avatar;
use App\Services\BonusService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberService
{
    /**
     *
     * @param int $id
     * @param string $type 'user' or 'avatar'
     * @param int|null $root_id
     * @return Member
     * @throws \Exception
     */
    public function addMember(int $id, string $type = 'user', int $root_id = null)
    {
        $root_id = $root_id ?? 1;
        $root_node = $this->buildMemberTree($root_id);
        $position_data = $this->findAvailableParentInTree($root_node);

        if (!$position_data) {
            throw new \Exception('No available position found in the tree.');
        }

        $member = Member::create([
            'user_id'   => $type === 'user' ? $id : null,
            'avatar_id' => $type === 'avatar' ? $id : null,
            'parent_id' => $position_data['parent_id'],
            'position'  => $position_data['position'],
            'referrer_id' => $root_id,
            'level'     => $position_data['level'],
            'is_valid' => $type === 'user' ? 'n' : 'y',
        ]);

        $coins = Coin::pluck('id');

        foreach($coins as $id) {
            Asset::create([
                'member_id' => $member->id,
                'coin_id' => $id,
            ]);

            Income::create([
                'member_id' => $member->id,
                'coin_id' => $id,
            ]);
        }

        $member = Member::find($member->id);
        $member->checkMemberGrade();

        if ($type == 'avatar') {
            $this->avatarMining($member->avatar_id);
        }
    }

    /**
     *
     * @param User $root
     * @return Member
     */
    public function addAvatar(Member $root)
    {
        $avatar_count = Avatar::where('owner_id', $root->member_id)->count() + 1;

        if ($root->user_id) {
            $owner_id = $root->user_id;
            $name = $root->member_id . '_' .$avatar_count;
        } else {
            $owner_id = $root->avatar->owner_id;
            $name = $root->member_id . '_' .$avatar_count;
        }

        $avatar = Avatar::create([
            'owner_id' => $owner_id,
            'name'     => $name,
        ]);

        return $avatar;
    }

    /**
     *
     * @param int $onwer_id
     * @param int $target_id
     * @return bool
     */
    public function hasMemberInTree(int $owner_id, int $target_id)
    {
        $tree = $this->buildMemberTree($owner_id);
        return $this->searchTree($tree, $target_id);
    }

    /**
     * Parse Member code.
     *
     *
     * @return Array
     */
    public function memberParseCode(string $code)
    {
        $prefix = mb_substr($code, 0, 1);
        $number = mb_substr($code, 1);

        if ($prefix === 'A') {
            $type = 'avatar';
        } else {
            $type = 'user';
        }

        return ['type' => $type, 'id' => $number];
    }

    /**
     *
     * @param int $root_id
     * @return array
     */
    private function buildMemberTree(int $root_id)
    {
        $member = Member::with('children')->find($root_id);

        if (!$member) {
            throw new \Exception("Member not found");
        }

        $tree = [
            'id' => $member->id,
            'member' => $member,
            'children' => [],
        ];

        foreach ($member->children as $child) {
            $tree['children'][] = $this->buildMemberTree($child->id);
        }

        return $tree;
    }

    /**
     *
     * @param array $rootNode
     * @return array|null
     */
    private function findAvailableParentInTree(array $root_node)
    {
        $queue = [$root_node];

        while (!empty($queue)) {
            $current = array_shift($queue);

            $left = null;
            $right = null;

            foreach ($current['children'] as $child) {
                if ($child['member']->position === 'left') $left = $child;
                if ($child['member']->position === 'right') $right = $child;
            }

            if (!$left) {
                return ['parent_id' => $current['id'], 'position' => 'left', 'level' => $current['member']->level + 1];
            }

            if (!$right) {
                return ['parent_id' => $current['id'], 'position' => 'right', 'level' => $current['member']->level + 1];
            }

            foreach ($current['children'] as $child) {
                $queue[] = $child;
            }
        }

        return null;
    }

    /**
     *
     * @param array $tree
     * @param int $target_id
     * @return bool
     */
    private function searchTree(array $tree, int $target_id)
    {
        if ($tree['id'] === $target_id) {
            return true;
        }

        foreach ($tree['children'] as $child) {
            if ($this->searchTree($child, $target_id)) {
                return true;
            }
        }

        return false;
    }

    private function findParentsInTree($node, $target_id, &$parents, $path = [])
    {
        $path[] = $node['member'];

        if ($node['id'] == $target_id) {
            for ($i = 0; $i < count($path) - 1; $i++) {
                $parents[$i + 1] = $path[$i];
            }

            return true;
        }

        foreach ($node['children'] as $child) {
            if ($this->findParentsInTree($child, $target_id, $parents, $path)) {
                return true;
            }
        }

        return false;
    }

    private function avatarMining(int $avatar_id)
    {

        $avatar = Avatar::find($avatar_id);

        $policy = miningPolicy::first();
        $product = MiningProduct::find($policy->avatar_product_id);

        $asset = Asset::where('member_id', $avatar->member->id)->where('coin_id', $product->coin_id)->first();
        $income = Income::where('member_id', $avatar->member->id)->where('coin_id', $product->coin_id)->first();

        $start = Carbon::today()->addDays($product->waiting_period+1);

        $mining = Mining::create([
            'member_id' => $avatar->member->id,
            'asset_id' => $asset->id,
            'income_id' => $income->id,
            'product_id' => $product->id,
            'entry_amount' => $product->entry_amount,
            'reward_count' => 0,
            'reward_limit' => $product->reward_limit,
            'started_at' => $start,
        ]);

        AssetTransfer::create([
            'member_id' => $avatar->member->id,
            'asset_id' => $asset->id,
            'type' => 'deposit',
            'status' => 'completed',
            'amount' => $product->entry_amount,
            'actual_amount' => $product->entry_amount,
            'before_balance' => 0,
            'after_balance' => $product->entry_amount,
        ]);


        AssetTransfer::create([
            'member_id' => $avatar->member->id,
            'asset_id' => $asset->id,
            'type' => 'mining',
            'status' => 'completed',
            'amount' => $product->entry_amount,
            'actual_amount' => $product->entry_amount,
            'before_balance' => $product->entry_amount,
            'after_balance' => 0,
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

        $service = new BonusService();
        $service->referralBonus($mining);

    }

}
