@extends('layouts.master')

@section('content')
    <main class="container-fluid py-5 mb-5">
        <div class="mb-4">
            <h3>{{ __('asset.referrer_info') }}</h3>
        </div>
        <div class="table-responsive overflow-x-auto">
            <div class="pt-2 avatar_list">
                @foreach ($referrals as $referral)
                    <div class="text-body mb-2 referral_box referral_{{ $level }}">
                        <a href="{{ $referral->referral_count > 0 ? route('profile.referral', ['id' => $referral->id]): '#'}}">
                            <div class="d-flex align-items-center mb-3 pb-2 justify-content-end level_t">
                                <p class="text-body fs-5 m-0 me-2 key_color fw-bold">{{ __('Level') }}</p>
                                <p class="text-body fs-5 m-0 key_color fw-bold">{{ $level }}</p>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex mb-2">
                                    <p class="text-body fs-4 me-2 mb-0 fw-medium">{{ __('user.uid') }}</p>
                                    <p class="text-body fs-4 mb-0">{{ $referral->member_id }}</p>
                                </div>
                                <div class="d-flex mb-2">
                                    <p class="text-body fs-4 me-2 mb-0 fw-medium">{{ __('user.email') }}</p>
                                    @if ($referral->user_id)
                                        <p class="text-body fs-4 mb-0">{{ $referral->user->profile->email }}</p>
                                    @else
                                        <p class="text-body fs-4 mb-0">{{ __('-') }}</p>
                                    @endif
                                </div>
                                <div class="d-flex mb-2">
                                    <p class="text-body fs-4 me-2 mb-0 fw-medium">{{ __('system.joined_at') }}</p>
                                    <p class="text-body fs-4 mb-0">{{ date_format($referral->created_at, 'Y-m-d')  }}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-body fs-4 me-2 mb-0 fw-medium">{{ __('mining.entry_amount') }}</p>
                                    <p class="text-body fs-4 mb-0">{{ number_format($referral->total_entry_amount) }}</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-body fs-4 me-2 mb-0 fw-medium">{{ __('asset.referral_count') }}</p>
                                    <p class="text-body fs-4 mb-0">{{ $referral->referral_count }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
