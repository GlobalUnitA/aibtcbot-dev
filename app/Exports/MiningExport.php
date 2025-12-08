<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class MiningExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {

        $query = DB::table('minings')
            ->leftJoin('members', 'minings.member_id', '=', 'members.id')
            ->leftJoin('users', 'members.user_id', '=', 'users.id')
            ->leftJoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->leftJoin('member_grades', 'members.grade_id', '=', 'member_grades.id')
            ->leftJoin('mining_products', 'minings.product_id', '=', 'mining_products.id')
            ->leftJoin('mining_product_translations', 'mining_products.id', '=', 'mining_product_translations.product_id')
            ->leftJoin('coins', 'mining_products.coin_id', '=', 'coins.id')


            ->select(
                'minings.id',
                'users.id as user_id',
                'users.name',
                'coins.name as coin_name',
                'minings.entry_amount',
                'mining_product_translations.name as product_name',
                'minings.status',
                'minings.created_at',
            )
            ->where('mining_product_translations.locale', 'ko')
            ->orderBy('minings.created_at', 'asc');


        if (!empty($this->filters['keyword']) && $this->filters['category'] == 'mid') {
            $query->where('users.id', $this->filters['keyword']);
        }

        if (!empty($this->filters['keyword']) && $this->filters['category'] == 'account') {
            $query->where('users.account', $this->filters['keyword']);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $start = Carbon::parse($this->filters['start_date'])->startOfDay();
            $end = Carbon::parse($this->filters['end_date'])->endOfDay();
            $query->whereBetween('minings.created_at', [$start, $end]);
        }

        $status_map = [
            'pending' => '진행중',
            'completed' => '완료',
        ];

        return $query->get()->map(function ($item) use ($status_map) {
            $item->status = $status_map[$item->status] ?? $item->status;
            return $item;
        });
    }


    public function headings(): array
    {
        return ['마이닝 번호', 'UID', '이름', '자산종류', '참여수량', '상품이름', '상태', '일자'];
    }
}
