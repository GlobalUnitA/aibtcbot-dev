@extends('layouts.master')

@section('content')

<main class="container-fluid py-5 mb-5 px-4">
    <div class="mb-4">
        <h3 class="text-center">{{ __('user.dashboard') }}</h3>
    </div>
    <div class="mb-5">
        <ul class="nav nav-underline tab-button mb-3 fs-6" id="dashboard-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dashboard-mypage-tab" data-bs-toggle="pill" data-bs-target="#dashboard-mypage" type="button" role="tab" aria-controls="dashboard-mypage" aria-selected="true">{{ __('asset.my_info') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="dashboard-myteam-tab" data-bs-toggle="pill" data-bs-target="#dashboard-myteam" type="button" role="tab" aria-controls="dashboard-myteam" aria-selected="false">{{ __('asset.team_info') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="dashboard-avatar-tab" data-bs-toggle="pill" data-bs-target="#dashboard-avatar" type="button" role="tab" aria-controls="dashboard-avatar" aria-selected="false">{{ __('user.avatar') }}</button>
            </li>
        </ul>
        <div class="tab-content content-d" id="dashboard-tabContent">
            <div class="tab-pane fade show active tabbox" id="dashboard-mypage" role="tabpanel" aria-labelledby="dashboard-mypage-tab" tabindex="0">
                <p class="fs-4 lavel_info pb-3 mb-0">
                    {{ __('user.level') }}<span class="text-body fw-semibold ps-2 d-inline-block">{{ $data['grade'] }}</span>
                </p>
                <div class="text-body mt-3">
                    <div class="g-3">
                        <div class="col-12 col-sm-6 d-flex gap-4">
                            <p class="text-body fs-4 m-0">{{ __('mining.total_node') }}</p>
                            <h3 class="text-primary fs-5 mb-0">{{ $data['total_node_amount'] }}</h3>
                        </div>
                    </div>
                    @foreach ($data['total_reward'] as $coin => $reward)
                        <div class="g-3 mb-3">
                            <div class="col-12 col-sm-6 d-flex gap-4">
                                <p class="text-body fs-4 m-0">{{ __('mining.total_mining').' ('.$coin.')' }}</p>
                                <h3 class="text-primary fs-5 mb-0">{{ $reward }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade show" id="dashboard-myteam" role="tabpanel" aria-labelledby="dashboard-myteam-tab" tabindex="0">
                <div class="text-body tabbox">
                    <div class="g-3">
                        <div class="col-12 col-sm-6 d-flex gap-4">
                            <p class="text-body fs-4 m-0">{{ __('asset.referral_count') }}</p>
                            <h3 class="text-primary fs-5 mb-0">{{ $data['referral_count'] }}</h3>
                        </div>
                    </div>
                    <div class="g-3 mt-3">
                        <div class="col-12 col-sm-6 d-flex gap-4">
                            <p class="text-body fs-4 m-0">{{ __('asset.child_count') }}</p>
                            <h3 class="text-primary fs-5 mb-0">{{ $data['all_count'] }}</h3>
                        </div>
                    </div>
                    <div class="g-3 mt-3">
                        <div class="col-12 col-sm-6 d-flex gap-4">
                            <p class="text-body fs-4 m-0">{{ __('asset.total_group_sales') }}</p>
                            <h3 class="text-primary fs-5 mb-0">{{ $data['group_sales'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="dashboard-avatar" role="tabpanel" aria-labelledby="dashboard-avatar-tab" tabindex="0">
                <p class="fs-4 mb-2 tabbox_bg">
                    {{ __('user.avatar') }} {{ __('system.amount') }}<span class="text-body fw-semibold ps-2 d-inline-block">{{ $data['avatars']->count() }}</span>
                </p>
                <div class="pt-2 avatar_list">
                @foreach ($data['avatars'] as $avatar)
                    <div class="text-body mb-2 tabbox">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <a href="{{ route('avatar.view', ['id' => $avatar->id]) }}">
                                <p class="text-body fs-5 m-0" style="font-weight:bold;color:#6976A2 !important;font-weight: bold;display: inline-block;vertical-align: middle;">{{ __('user.avatar') }} {{ $loop->iteration }}</p>
                                <img src="{{ asset('images/icon/right_icon_g.svg') }}" style="display: inline-block;width: auto;height: 24px;">
                            </a>
                            @if ($avatar->is_active === 'n')
                            <p class="mb-0 sign_inactive">{{ __('system.inactive') }}</p>
                            @else
                            <p class="mb-0 sign_active">{{ __('system.active') }}</p>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-body fs-4 m-0">{{ $avatar->name }}</p>
                            @if ($avatar->is_active === 'y')
                            <a href="{{ route('register',['mid' => $avatar->member->member_id]) }}">
                                <!-- <p class="text-body fs-4 mb-1">+</p> -->
                                <img src="{{ asset('images/icon/plus-solid.svg') }}" style="height:35px;">
                            </a>
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
