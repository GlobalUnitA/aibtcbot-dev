@extends('layouts.master')

@section('content')
<main class="container-fluid py-5 mb-5 px-4">
    <div class="mb-4">
        <h3>{{ __('asset.profit_detail') }}</h3>
    </div>
    <div class="g-3 mb-5 content-d mt-0">
        <div class="p-4 mb-4 tabbox_bg text-body box_b_line">
            {{--
            <div class="d-flex justify-content-between align-items-center box_b_line">
                <p class="text-body fs-4 m-0">{{ __('asset.total_subscription_bonus') }}</p>
                <h3 class="key_color fs-6 mb-1">{{ $data['subscription_bonus'] }}</h3>
            </div>
            --}}
            <div class="d-flex justify-content-between align-items-center box_b_line">
                <p class="text-body fs-4 m-0">{{ __('asset.total_referral_bonus') }}</p>
                <h3 class="key_color fs-6 mb-1">{{ $data['referral_bonus'] }}</h3>
            </div>
            {{--
            <div class="d-flex justify-content-between align-items-center box_b_line">
                <p class="text-body fs-4 m-0">{{ __('asset.total_referral_bonus_matching') }}</p>
                <h3 class="key_color fs-6 mb-1">{{ $data['referral_matching'] }}</h3>
            </div>
            <div class="d-flex justify-content-between align-items-center box_b_line">
                <p class="text-body fs-4 m-0">{{ __('asset.total_rank_bonus') }}</p>
                <h3 class="key_color fs-6 mb-1">{{ $data['rank_bonus'] }}</h3>
            </div>
            --}}
            {{--
            <div class="d-flex justify-content-between align-items-center box_b_line">
                <p class="text-body fs-4 m-0">{{ __('mining.total_mining_profit') }}</p>
                <h3 class="key_color fs-6 mb-1">{{ __('???') }}</h3>
            </div>
            <div class="d-flex justify-content-between align-items-center box_b_line">
                <p class="text-body fs-4 m-0">{{ __('mining.total_mining_level_bonus') }}</p>
                <h3 class="key_color fs-6 mb-1">{{ __('???') }}</h3>
            </div>
            <div class="d-flex justify-content-between align-items-center box_b_line">
                <p class="text-body fs-4 m-0">{{ __('mining.total_mining_matching_bonus') }}</p>
                <h3 class="key_color fs-6 mb-1">{{ __('???') }}</h3>
            </div>
            --}}
            <div class="box_b_line">
                <div class="d-flex gap-4 align-items-center justify-content-between mb-1">
                    <p class="text-body fs-4 m-0">{{ __('asset.total_external_withdrawal') }}</p>
                    <h3 class="key_color fs-6 mb-1">{{ $data['withdrawal_total'] }}</h3>
                </div>
                <div class="text-end">
                    <a href="{{ route('income.withdrawal') }}" class="btn btn-primary fs-4 py-1 px-3">{{ __('asset.withdrawal') }}</a>
                </div>
            </div>
            {{--
            <div class="box_b_line">
                <div class=" d-flex gap-4 align-items-center justify-content-between mb-1">
                    <p class="text-body fs-4 m-0">{{ __('asset.total_internal_transfer') }}</p>
                    <a href="{{ route('income.deposit') }}" class="btn btn-primary fs-4 py-1 px-3">{{ __('asset.internal_transfer') }}</a>
                </div>
                <div class="text-end">
                    <h3 class="key_color fs-6 mb-0">{{ $data['deposit_total'] }}</h3>
                </div>
            </div>
            --}}
            <div class="d-flex gap-4 align-items-center justify-content-between box_b_line">
                <p class="text-body fs-4 m-0">{{ __('asset.current_balance') }}</p>
                <h3 class="key_color fs-6 mb-1">{{ $data['balance'] }}</h3>
            </div>
            <div class="mb-0 d-flex gap-4 align-items-center justify-content-between box_b_line">
                <p class="text-body fs-4 m-0">{{ __('asset.total_avatar_cost') }}</p>
                <h3 class="key_color fs-6 mb-1">{{ $data['avatar_cost_total'] }}</h3>
            </div>
        </div>
    </div>
    <div class="table-responsive pb-5 table-nstyle">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('system.date') }}</th>
                    <th>{{ __('system.amount') }}</th>
                    <th>{{ __('user.child_id') }}</th>
                    <th>{{ __('system.category') }}</th>
                </tr>
            </thead>
            <tbody id="loadMoreContainer">
                @if($list->isNotEmpty())
                @foreach($list as $key => $val)
                <tr>
                    <td>{{ date_format($val->created_at, 'Y-m-d') }}</td>
                    <td>
                        {{ $val->amount }}
                    </td>
                    <td>
                        @if ($val->type === 'referral_bonus')
                            {{ $val->referralBonus ? $val->referralBonus->referrer->member_id : '' }}
                        @elseif ($val->type === 'referral_matching')
                            {{ $val->referralMatching ? $val->referralMatching->referrer->member_id : '' }}
                        @elseif ($val->type === 'level_bonus')
                            {{ $val->levelBonus ? $val->levelBonus->referrer->member_id : '' }}
                        @elseif ($val->type === 'level_matching')
                            {{ $val->levelMatching ? $val->levelMatching->referrer->member_id : '' }}
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
    </div>
</main>
@endsection

@push('script')
<script src="{{ asset('js/income/income.js') }}"></script>
@endpush

