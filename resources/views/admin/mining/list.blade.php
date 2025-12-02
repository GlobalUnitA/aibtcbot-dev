@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between">
                    <ul class="nav nav-tabs mt-3" id="tableTabs" role="tablist" >
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('admin.mining.list', array_merge(request()->query(), ['status' => 'pending'])) }}" class="nav-link {{ Request('status') == 'pending' ? 'active' : '' }}">진행중</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('admin.mining.list', array_merge(request()->query(), ['status' => 'completed'])) }}" class="nav-link {{ Request('status') == 'completed' ? 'active' : '' }}">만료</a>
                        </li>
                    </ul>
                </div>
                @include('components.search-form', ['route' => route('admin.mining.list')])
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-end">
                        <!--a href="{{ route('admin.asset.export') }}?{{ http_build_query(request()->query()) }}" class="btn btn-primary">Excel</a-->
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap align-middle mb-0 table-striped table-hover">
                                <thead>
                                    <tr class="border-2 border-bottom border-primary border-0">
                                        <th scope="col" class="text-center">번호</th>
                                        <th scope="col" class="text-center">마이닝 번호</th>
                                        <th scope="col" class="text-center">UID</th>
                                        <th scope="col" class="text-center">이름</th>
                                        <th scope="col" class="text-center">종류</th>
                                        <th scope="col" class="text-center">참여수량</th>
                                        <th scope="col" class="text-center">상품이름</th>
                                        <th scope="col" class="text-center">상태</th>
                                        <th scope="col" class="text-center">일자</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @if($list->isNotEmpty())
                                    @foreach ($list as $key => $value)
                                    <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.mining.view', ['id' => $value->id]) }}';">
                                        <td scope="col" class="text-center">{{ $list->firstItem() + $key }}</td>
                                        <td scope="col" class="text-center">{{ $value->id }}</td>
                                        <td scope="col" class="text-center">{{ $value->member->member_id }}</td>
                                        <td scope="col" class="text-center">{{ $value->member->member_name }}</td>
                                        <td scope="col" class="text-center">{{ $value->product->coin->name }}</td>
                                        <td scope="col" class="text-center">{{ $value->entry_amount }}</td>
                                        <td scope="col" class="text-center">{{ $value->product->mining_locale_name }}</td>
                                        <td scope="col" class="text-center">
                                            @switch($value->status)
                                                @case('pending')
                                                    {{ __('진행중') }}
                                                    @break
                                                @case('completed')
                                                    {{ __('만료') }}
                                            @endswitch
                                        </td>
                                        <td scope="col" class="text-center">{{ $value->created_at }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="10">No Data.</td>
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
