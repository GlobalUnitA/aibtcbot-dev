@extends('layouts.master')

@section('content')
<main class="container-fluid py-5 mb-5 px-4">
    <div class="mb-4">
        <h3>{{ __('AI BTC BOT') }}</h3>
    </div>
    <div class="mb-5 pt-3 table-nstyle content-d">
        <div class="text-black mb-2">
            <div class="tabbox_bg">
                <div class="d-flex gap-3 mb-2">
                    <p class="text-body fs-4 m-0">{{ __('system.started_at') }}</p>
                    <h3 class="key_color fs-5 mb-0">{{ date_format($date['start'], 'Y-m-d') }}</h3>
                </div>
                <div class="d-flex gap-3">
                    <p class="text-body fs-4 m-0">{{ __('mining.reward_count') }}</p>
                    <h3 class="text-primary fs-5 mb-0">{{ $product->reward_limit }}</h3>
                </div>
            </div>
        </div>
        <p class="mb-3 mt-4 fs-4">{!! nl2br(e($product->mining_locale_memo)) !!}</p>
        <div class="tabbox pt-5">
            <form method="post" action="{{ route('mining.store') }}" id="ajaxForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="mb-3 form_line">
                    <label class="form-label fs-4 text-body">{{ $product->coin->name }} {{ __('system.amount') }}</label>
                    <input type="text" name="entry_amount" id="refundCoinAmount" class="form-control" value="{{ $product->entry_amount }}" readonly>
                </div>
                <p class="mb-5 opacity-50 fw-light fs-4">{{ __('system.stock_amount') }}: <span class="fw-bold">{{ number_format($balance) }}</span></p>
                <button type="submit" class="btn btn-primary w-100 py-9 fs-4 mt-4 rounded-3" >{{ __('mining.participate') }}</button>
            </form>
        </div>
    </div>
</main>

@endsection

@push('script')
<script src="{{ asset('js/mining/mining.js') }}"></script>
@endpush
