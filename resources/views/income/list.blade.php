@extends('layouts.master')

@section('content')
<div class="container py-5">
    <h2 class="mb-3 text-center">{{ __('asset.profit_detail') }}</h2>
    <hr>
    <div class="table-responsive overflow-x-auto mb-5">
        <table class="table table-striped table-bordered break-keep-all m-0 mb-5">
            <thead class="mb-2">
                <tr>
                    <th>{{ __('system.date') }}</th>
                    <th>{{ __('system.amount') }}</th>
                    <th>{{ __('user.child_id') }}</th>
                    <th>{{ __('system.category') }}</th>
                </tr>
            </thead>
            <tbody id="loadMoreContainer">
                @if($list->isNotEmpty())
                @foreach($list as $key => $value)
                <tr>
                    <td>{{ $value->created_at->format('Y-m-d') }}</td>
                    <td>{{ $value->amount }}</td>
                    <td>
                        @if ($value->type === 'subscription_bonus')
                            {{ $value->subscriptionBonus ? $value->subscriptionBonus->referrer->member_id : '' }}
                        @elseif ($value->type === 'referral_bonus')
                            {{ $value->referralBonus ? $value->referralBonus->referrer->member_id : '' }}
                        @elseif ($value->type === 'referral_matching')
                            {{ $value->referralMatching ? $value->referralMatching->referrer->member_id : '' }}
                        @elseif ($value->type === 'level_bonus')
                            {{ $value->levelBonus ? $value->levelBonus->referrer->member_id : '' }}
                        @elseif ($value->type === 'level_matching')
                            {{ $value->levelMatching ? $value->levelMatching->referrer->member_id : '' }}
                        @else
                            {{ '' }}
                        @endif
                    </td>
                    <td>
                        {{ $value->type_text }}
                        @if ($value->type === 'referral_bonus')
                            @php
                                $name = optional(optional(optional($value->referralBonus)->mining)->policy)->mining_locale_name;
                            @endphp
                            {!! !empty($name) ? '<br>(' . e($name) . ')' : '' !!}
                        @elseif ($value->type === 'referral_matching')
                            @php
                                $name = optional(optional(optional(optional($value->referralMatching)->bonus)->mining)->policy)->mining_locale_name;
                            @endphp
                            {!! !empty($name) ? '<br>(' . e($name) . ')' : '' !!}
                        @elseif ($value->type === 'level_bonus')
                            @php
                                $name = optional(optional(optional($value->levelBonus)->mining)->policy)->mining_locale_name;
                            @endphp
                            {!! !empty($name) ? '<br>(' . e($name) . ')' : '' !!}
                        @elseif ($value->type === 'level_matching')
                            @php
                                $name = optional(optional(optional(optional($value->levelMatching)->bonus)->mining)->policy)->mining_locale_name;
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
        <form method="POST" action="{{ route('income.list.loadMore') }}" id="loadMoreForm">
            @csrf
            <input type="hidden" name="offset" value="10">
            <input type="hidden" name="limit" value="10">
            <input type="hidden" name="id" value="{{ request('id') }}">
            <input type="hidden" name="type" value="{{ request('type') }}">
            <button type="submit" class="btn btn-outline-primary w-100 py-2 my-4 fs-4">{{ __('system.load_more') }}</button>
        </form>
        @endif
    </div>
</div>
@endsection

@push('script')
@verbatim
<template id="loadMoreTemplate">
    <tr>
        <td>{{created_at}}</td>
        <td>{{amount}}</td>
        <td>{{referrer_id}}</td>
        <td>{{type_text}}</td>
    </tr>
</template>
@endverbatim
<script src="{{ asset('js/income/income.js') }}"></script>
@endpush
