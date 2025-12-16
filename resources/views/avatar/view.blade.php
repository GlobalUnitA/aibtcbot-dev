@extends('layouts.master')

@section('content')
    <main class="container-fluid py-5 mb-5 px-4 content-d">
        <div class="mb-3 tabbox_bg">
            <div class="justify-content-start align-items-center">
                <p class="mb-3 position-relative fs-4">
                    UID<span class="fw-semibold d-inline-block ps-2">{{ $view->member->member_id }}</span>
                </p>
                <p class="mb-0 position-relative fs-4">
                    가입상품<span class="fw-semibold d-inline-block ps-2">50 USDT</span>
                </p>
            </div>
        </div>
        <div class="g-3">
            <div class="px-4 py-3 text-body tabbox">
                <h2 class="mb-3 fs-5">{{ __('asset.team_info') }}</h2>
                <div class="mb-2 d-flex gap-4">
                    <p class="text-body fs-4 m-0">{{ __('asset.referral_count') }}</p>
                    <h3 class="fs-5 mb-0"  >{{ $view->member->referral_count  }}</h3>
                </div>
                <div class="mb-2 d-flex gap-4">
                    <p class="text-body fs-4 m-0">{{ __('asset.child_count') }}</p>
                    <h3 class="fs-5 mb-0" style="color:#ff7e00;">{{ collect($view->member->getChildrenTree())->map->count()->sum() }}</h3>
                </div>
                <div class="mb-0 d-flex gap-4">
                    <p class="text-body fs-4 m-0">{{ __('asset.total_group_sales') }}</p>
                    <h3 class="fs-5 mb-0" style="color:#ff7e00;">{{ $view->member->getGroupSales() }}</h3>
                </div>
            </div>
        </div>
        <div class="table-responsive pb-5">
            {{--
            <table class="table table-striped table-bordered">
                <thead class="mb-2">
                <tr>
                    <th>{{ __('system.date') }}</th>
                    <th>{{ __('system.amount') }}</th>
                    <th>{{ __('user.child_id') }}</th>
                    <th>
                        <select id="incomeTypeSelect" name="type" class="form-select form-select-sm">
                            <option value="">{{ __('system.category') }}</option>
                            {{--<option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>{{ __('asset.internal_transfer') }}</option>--}}
                            {{--
                            <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>{{ __('asset.external_withdrawal') }}</option>
                            <option value="mining_profit" {{ request('type') == 'mining_profit' ? 'selected' : '' }}>{{ __('mining.mining_profit') }}</option>
                            <option value="rank_bonus" {{ request('type') == 'rank_bonus' ? 'selected' : '' }}>{{ __('asset.rank_bonus') }}</option>
                            <option value="referral_bonus" {{ request('type') == 'referral_bonus' ? 'selected' : '' }}>{{ __('asset.referral_bonus') }}</option>
                            <option value="referral_matching" {{ request('type') == 'referral_matching' ? 'selected' : '' }}>{{ __('asset.referral_bonus_matching') }}</option>
                            <option value="level_bonus" {{ request('type') == 'level_bonus' ? 'selected' : '' }}>{{ __('mining.mining_level_bonus') }}</option>
                            <option value="level_matching" {{ request('type') == 'level_matching' ? 'selected' : '' }}>{{ __('mining.mining_matching_bonus') }}</option>
                        </select>
                    </th>
                </tr>
                </thead>
                <tbody id="loadMoreContainer">
                @if($list->isNotEmpty())
                    @foreach($list as $key => $val)
                        <tr>
                            <td>{{ date_format($val->created_at, 'Y-m-d') }}</td>
                            <td>{{ $val->amount }}</td>
                            <td>
                                @if ($val->type === 'referral_bonus')
                                    {{ $val->referralBonus ? $val->referralBonus->referrer_id : '' }}
                                @elseif ($val->type === 'referral_matching')
                                    {{ $val->referralMatching ? $val->referralMatching->referrer_id : '' }}
                                @elseif ($val->type === 'level_bonus')
                                    {{ $val->levelBonus ? $val->levelBonus->referrer_id : '' }}
                                @elseif ($val->type === 'level_matching')
                                    {{ $val->levelMatching ? $val->levelMatching->referrer_id : '' }}
                                @endif
                            </td>
                            <td>
                                {{ $val->type_text }}
                                @if ($val->type === 'mining_profit')
                                    @if ($val->miningProfit->type == 'instant')
                                        {{ '('.__('system.instant').')' }}
                                    @else
                                        {{ '('.__('system.split').')' }}
                                    @endif
                                @elseif ($val->type === 'referral_bonus')
                                    @php
                                        $name = optional(optional(optional($val->referralBonus)->mining)->policy)->mining_locale_name;
                                    @endphp
                                    {!! !empty($name) ? '<br>(' . e($name) . ')' : '' !!}
                                @elseif ($val->type === 'referral_matching')
                                    @php
                                        $name = optional(optional(optional(optional($val->referralMatching)->bonus)->mining)->policy)->mining_locale_name;
                                    @endphp
                                    {!! !empty($name) ? '<br>(' . e($name) . ')' : '' !!}
                                @elseif ($val->type === 'level_bonus')
                                    @php
                                        $name = optional(optional(optional($val->levelBonus)->mining)->policy)->mining_locale_name;
                                    @endphp
                                    {!! !empty($name) ? '<br>(' . e($name) . ')' : '' !!}
                                @elseif ($val->type === 'level_matching')
                                    @php
                                        $name = optional(optional(optional(optional($val->levelMatching)->bonus)->mining)->policy)->mining_locale_name;
                                    @endphp
                                    {!! !empty($name) ? '<br>(' . e($name) . ')' : '' !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">No data.</td>
                    </tr>
                @endif
                </tbody>
            </table>
            @if($has_more)
                <a href="{{ route('income.list',['id' => $data['encrypted_id']]) }}" class="btn btn-outline-primary w-100 py-2 my-4 fs-4">{{ __('system.load_more') }}</a>
            @endif
            --}}
        </div>
    </main>
@endsection


