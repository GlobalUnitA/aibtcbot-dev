@extends('layouts.master')

@section('content')
<header class="px-4 py-5 w-100 border-top-title" style="background: url('../../images/tit_bg_01.png') center right no-repeat, #1e1e1f;" >
    <h2 class="text-white mb-1 px-1">{{ __('AI BTC BOT') }}</h2>
    <h6 class="text-white mb-4 px-1">{{ __('AI BTC BOT') }}</h6>
</header>
<main class="container-fluid py-5 mb-5">
    <div class="px-3 mb-5">
        <div class="p-4 rounded bg-light text-black mb-2">
            <div class="row g-3">
                <div class="col-6">
                    <p class="text-body fs-4 m-0">{{ __('system.started_at') }}</p>
                    <h3 class="text-primary fs-6 mb-1">{{ date_format($date['start'], 'Y-m-d') }}</h3>
                </div>
                <div class="col-6">
                    <p class="text-body fs-4 m-0">{{ __('mining.reward_count') }}</p>
                    <h3 class="text-primary fs-6 mb-1">{{ $product->reward_limit }}</h3>
                </div>
            </div>
        </div>
        <p class="mb-5 mt-4 fs-4">{!! nl2br(e($product->mining_locale_memo)) !!}</p>
        <form method="post" action="{{ route('mining.store') }}" id="ajaxForm">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="mb-3">
                <label class="form-label fs-4 text-body">{{ $product->coin->name }} {{ __('system.amount') }}</label>
                <input type="text" name="entry_amount" id="refundCoinAmount" class="form-control" value="{{ $product->entry_amount }}" readonly>
            </div>
            <p class="mb-5 opacity-50 fw-light fs-4">{{ __('system.stock_amount') }}: <span class="fw-bold">{{ number_format($balance) }}</span></p>
            <button type="submit" class="btn btn-primary w-100 py-3 mb-4 fs-4" >{{ __('mining.participate') }}</button>
        </form>
    </div>
</main>

@endsection

@push('script')
<script src="{{ asset('js/mining/mining.js') }}"></script>
@endpush
