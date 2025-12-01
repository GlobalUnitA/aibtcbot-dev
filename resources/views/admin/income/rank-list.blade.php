@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.income.tabs')
                @include('components.search-form', ['route' => route('admin.income.list', ['type' => 'rank_bonus'])])
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-end">
                        <a href="{{ route('admin.income.export') }}?{{ http_build_query(request()->query()) }}" class="btn btn-primary">Excel</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap align-middle mb-0 table-striped table-hover">
                                <thead>
                                    <tr class="border-2 border-bottom border-primary border-0">
                                        <th scope="col" class="text-center">번호</th>
                                        <th scope="col" class="text-center">UID</th>
                                        <th scope="col" class="text-center">이름</th>
                                        <th scope="col" class="text-center">등급</th>
                                        <th scope="col" class="text-center">종류</th>
                                        <th scope="col" class="text-center">보너스</th>
                                        <th scope="col" class="text-center">개인매출</th>
                                        <th scope="col" class="text-center">그룹매출</th>
                                        <th scope="col" class="text-center">직추천 수</th>
                                        <th scope="col" class="text-center">보너스 등급</th>
                                        <th scope="col" class="text-center">지급일자</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @if($list->isNotEmpty())
                                    @foreach ($list as $key => $value)
                                    <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.income.view', ['id' => $value->id]) }}';">
                                        <td scope="col" class="text-center">{{ $list->firstItem() + $key }}</td>
                                        <td scope="col" class="text-center">{{ $value->member->member_id }}</td>
                                        <td scope="col" class="text-center">{{ $value->member->user->name }}</td>
                                        <td scope="col" class="text-center">{{ $value->member->grade->name }}</td>
                                        <td scope="col" class="text-center">{{ $value->income->coin->name }}</td>
                                        <td scope="col" class="text-center">{{ $value->amount }}</td>
                                        <td scope="col" class="text-center">{{ $value->rankBonus->self_sales }}</td>
                                        <td scope="col" class="text-center">{{ $value->rankBonus->group_sales }}</td>
                                        <td scope="col" class="text-center">{{ $value->rankBonus->referral_count }}</td>
                                        <td scope="col" class="text-center">{{ $value->rankBonus->policy->grade->name }}</td>
                                        <td scope="col" class="text-center">{{ $value->created_at }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="11">No Data.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            {{ $list->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
