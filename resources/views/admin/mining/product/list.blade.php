.@extends('admin.layouts.master')

@section('content')
<div class="body-wrapper">
    <div class="container-fluid">
        <ul class="nav nav-tabs mt-3" id="tableTabs" role="tablist" >
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.mining.policy') }}" class="nav-link">
                    마이닝 정책
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.mining.product') }}" class="nav-link active">
                    마이닝 상품
                </a>
            </li>
        </ul>
        <div class="card">
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    <h5 class="card-title">마이닝 상품</h5>
                </div>
                <hr>
                <div>
                    <table class="table text-nowrap align-middle mb-0 table-striped">
                        <thead>
                            <tr class="border-2 border-bottom border-primary border-0">
                                <th scope="col" class="ps-0 text-center">상품이름</th>
                                <th scope="col" class="text-center">참여수량</th>
                                <th scope="col" class="text-center">수익 횟수</th>
                                <th scope="col" class="text-center">수정일자</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        @if($products->isNotEmpty())
                            @foreach($products as $product)
                            <tr class="staking_policy" style ="cursor:pointer;" onclick="window.location='{{ route('admin.mining.product.view', ['mode' => 'setting', 'id' => $product->id]) }}'">
                                <td class="text-center">{{ $product->mining_locale_name }}</td>
                                <td class="text-center">{{ $product->entry_amount }}</td>
                                <td class="text-center">{{ $product->reward_limit }}</td>
                                <td class="text-center">{{ $product['updated_at'] }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">노드 마이닝 상품이 없습니다.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <hr>
                    <div class="d-flex mt-5">
                        <a href="{{ route('admin.mining.product.view', ['mode' => 'create']) }}" class="btn btn-info ms-auto">상품 추가</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
