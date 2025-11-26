.@extends('admin.layouts.master')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
            <ul class="nav nav-tabs mt-3" id="tableTabs" role="tablist" >
                <li class="nav-item" role="presentation">
                    <a href="{{ route('admin.mining.policy') }}" class="nav-link active">
                        마이닝 정책
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('admin.mining.product') }}" class="nav-link">
                        마이닝 상품
                    </a>
                </li>
            </ul>
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <h5 class="card-title">마이닝 정책</h5>
                    </div>
                    <form method="POST" action="{{ route('admin.mining.policy.update') }}" id="ajaxForm" data-confirm-message="정책을 변경하시겠습니까?">
                        @csrf
                        <input type="hidden" name="id" value="{{ $policy->id }}">
                        <hr>
                        <table class="table table-bordered mt-5 mb-5">
                            <tbody>
                            <tr>
                                <th class="text-center align-middle">아바타 가입 상품</th>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <select name="avatar_product_id" class="form-select">
                                            <option value="">상품 선택</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" @selected($policy->avatar_product_id == $product->id)>{{ $product->mining_locale_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <th class="text-center align-middle">최대 참여 금액</th>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="text" name="max_entry_amount" value="{{ $policy->max_entry_amount }}" class="form-control w-25">
                                        <span>USDT</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-danger">수정</button>
                        </div>
                    </form>
                </div>
            </div>
            @if($modify_logs->isNotEmpty())
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <h5 class="card-title">정책 변경 로그</h5>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table text-nowrap align-middle mb-0 table-striped">
                                <thead>
                                <tr class="border-2 border-bottom border-primary border-0">
                                    <th scope="col" class="ps-0 text-center">변경 내용</th>
                                    <th scope="col" class="ps-0 text-center">변경 전</th>
                                    <th scope="col" class="ps-0 text-center">변경 후</th>
                                    <th scope="col" class="ps-0 text-center">관리자</th>
                                    <th scope="col" class="ps-0 text-center">수정일자</th>
                                </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                @foreach($modify_logs as $key => $val)
                                    <tr>
                                        <td class="text-center">{{ $val->column_description }}</td>
                                        <td class="text-center">{{ $val->old_value }}</td>
                                        <td class="text-center">{{ $val->new_value }}</td>
                                        <td class="text-center">{{ $val->name }}</td>
                                        <td class="text-center">{{ $val->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
