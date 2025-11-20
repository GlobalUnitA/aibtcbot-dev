<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class UserExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {

        $query = DB::table('users')
            ->leftJoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->leftJoin('members', 'users.id', '=', 'members.user_id')
            ->leftJoin('member_grades', 'members.grade_id', '=', 'member_grades.id')
            ->leftJoin('members as referrer', 'members.referrer_id', '=', 'referrer.id')
            ->select(
                'users.account',
                'users.id',
                'users.name',
                'member_grades.name as grade_name',
                'user_profiles.phone',
                'user_profiles.email',
                'referrer.user_id as ref_user_id',
                'referrer.avatar_id as ref_avatar_id',
                'users.created_at',
            );


        if (!empty($this->filters['keyword']) && $this->filters['category'] == 'mid') {
            $query->where('users.id', $this->filters['keyword']);
        }

        if (!empty($this->filters['keyword']) && $this->filters['category'] == 'account') {
            $query->where('users.account', $this->filters['keyword']);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $start = Carbon::parse($this->filters['start_date'])->startOfDay();
            $end = Carbon::parse($this->filters['end_date'])->endOfDay();
            $query->whereBetween('users.created_at', [$start, $end]);
        }

        $results = $query->get();

        return $results->map(function ($item, $index) {

            $uid = 'U' . $item->id;

            if (!empty($item->ref_user_id)) {
                $referrer = 'U' . $item->ref_user_id;
            } elseif (!empty($item->ref_avatar_id)) {
                $referrer = 'A' . $item->ref_avatar_id;
            } else {
                $referrer = 'root';
            }

            return collect([
                '번호'     => $index + 1,
                '아이디'   => $item->account,
                'UID'      => $uid,
                '회원명'   => $item->name,
                '등급'     => $item->grade_name,
                '연락처'   => $item->phone,
                '이메일'   => $item->email,
                '추천인'   => $referrer,
                '가입일자' => $item->created_at,
            ]);
        });
    }


    public function headings(): array
    {
        return ['번호', '아이디', 'UID', '회원명', '등급', '연락처', '이메일', '추천인', '가입일자'];
    }
}
