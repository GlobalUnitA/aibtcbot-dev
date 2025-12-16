@extends('layouts.master')

@section('content')
    <main class="container-fluid py-5 mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <h3>{{ __('asset.referrer_info') }}</h3>
        </div>
        <div class="table-responsive overflow-x-auto">
            <div class="pt-2 avatar_list">
                @foreach ($referrals as $referral)
                    <div class="text-body mb-2 referral_box referral_{{ $level }}">
                        <a href="{{ route('profile.referral', ['id' => $referral->id]) }}">
                            <div class="d-flex align-items-center mb-2">
                                <p class="text-body fs-5 m-0 me-2">{{ __('Level') }}</p>
                                <p class="text-body fs-5 m-0">{{ $level }}</p>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex">
                                    <p class="text-body fs-5 me-2">{{ __('user.uid') }}</p>
                                    <p class="text-body fs-5">{{ $referral->member_id }}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-body fs-5 me-2">{{ __('user.email') }}</p>
                                    @if ($referral->user_id)
                                        <p class="text-body fs-5">{{ $referral->user->profile->email }}</p>
                                    @else
                                        <p class="text-body fs-5">{{ __('-') }}</p>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <p class="text-body fs-5 me-2">{{ __('system.joined_at') }}</p>
                                    <p class="text-body fs-5">{{ date_format($referral->created_at, 'Y-m-d')  }}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-body fs-5 me-2">{{ __('mining.entry_amount') }}</p>
                                    <p class="text-body fs-5">{{ number_format($referral->total_entry_amount) }}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-body fs-5 me-2">{{ __('asset.referral_count') }}</p>
                                    <p class="text-body fs-5">{{ $referral->referral_count }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
