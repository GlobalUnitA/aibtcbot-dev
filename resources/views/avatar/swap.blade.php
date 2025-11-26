@extends('layouts.master')

@section('content')
    <main class="container-fluid py-5 mb-5">
        <div class="pb-3 mb-2">
            <div class="justify-content-start align-items-center">
                <p class="mb-4 ps-3 position-relative fs-4">
                    UID<span class="fw-semibold d-inline-block ps-2">A5000012</span>
                </p>
                <p class="mb-4 ps-3 position-relative fs-4">
                    가입상품<span class="fw-semibold d-inline-block ps-2">50 USDT</span>
                </p>
            </div>
        </div>
        <div class="g-3">
            <div class="px-4 py-3 rounded bg-light text-body">
                <h2 class="mb-2 fs-4">{{ __('asset.team_info') }}</h2>
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <p class="text-body fs-4 m-0">{{ __('asset.referral_count') }}</p>
                    </div>
                    <h3 class="text-primary fs-6 mb-1">0</h3>
                </div>
                <div class="mb-4">
                    <div>
                        <p class="text-body fs-4 m-0">{{ __('asset.child_count') }}</p>
                        <h3 class="text-primary fs-6 mb-1">0</h3>
                    </div>
                </div>
                <div class="mb-4">
                    <div>
                        <p class="text-body fs-4 m-0">{{ __('asset.total_group_sales') }}</p>
                        <h3 class="text-primary fs-6 mb-1">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


