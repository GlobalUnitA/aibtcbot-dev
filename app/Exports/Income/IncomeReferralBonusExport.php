<?php

namespace App\Exports\Income;

use App\Exports\BaseIncomeExport;
use Illuminate\Support\Facades\DB;

class IncomeReferralBonusExport extends BaseIncomeExport
{
    public function collection()
    {
        $query = DB::table('income_transfers')
            ->leftJoin('incomes', 'income_transfers.income_id', '=', 'incomes.id')
            ->leftJoin('coins', 'incomes.coin_id', '=', 'coins.id')
            ->leftJoin('members', 'income_transfers.member_id', '=', 'members.id')
            ->leftJoin('users', 'members.user_id', '=', 'users.id')

            ->leftJoin('avatars', 'members.avatar_id', '=', 'avatars.id')

            ->leftJoin('member_grades', 'members.grade_id', '=', 'member_grades.id')
            ->leftJoin('referral_bonuses', 'income_transfers.id', '=', 'referral_bonuses.transfer_id')

            ->leftJoin('members as referrer', 'referral_bonuses.referrer_id', '=', 'referrer.id')

            ->leftJoin('minings', 'referral_bonuses.mining_id', '=', 'minings.id')

            ->select(
                'users.id',
                'users.name',
                'avatars.name as avatar_name',

                'members.user_id as member_user_id',
                'members.avatar_id as member_avatar_id',

                'referrer.user_id as referrer_user_id',
                'referrer.avatar_id as referrer_avatar_id',

                'member_grades.name as grade_name',
                'coins.name as coin_name',
                'income_transfers.amount as bonus',
                'income_transfers.status as status',
                'minings.entry_amount',
                'income_transfers.created_at'
            )
            ->orderBy('income_transfers.created_at', 'asc');

        $results = $this->applyCommonFilters($query)->get();

        return $this->formatExportRows($results);
    }


    public function headings(): array
    {
        return ['번호', 'UID', '이름', '등급', '종류', '보너스', '상태', '산하ID', '참여금액', '일자'];
    }

    private function buildUid($user_id, $avatar_id)
    {
        if (!empty($user_id)) {
            return 'U' . $user_id;
        }
        if (!empty($avatar_id)) {
            return 'A' . $avatar_id;
        }
        return '';
    }

    private function buildName($user_name, $avatar_name, $user_id)
    {
        return !empty($user_id) ? $user_name : $avatar_name;
    }

    protected function formatExportRows($results)
    {
        $rows = [];
        $no = 1;
        $statusMap = $this->getStatusMap();

        foreach ($results as $item) {

            $uid = $this->buildUid($item->member_user_id, $item->member_avatar_id);
            $name = $this->buildName($item->name, $item->avatar_name, $item->member_user_id);
            $referrerUid = $this->buildUid($item->referrer_user_id, $item->referrer_avatar_id);

            $rows[] = [
                $no++,
                $uid,
                $name,
                $item->grade_name,
                $item->coin_name,
                $item->bonus,
                $statusMap[$item->status] ?? $item->status,
                $referrerUid,
                $item->entry_amount,
                $item->created_at,
            ];
        }

        return collect($rows);
    }
}
