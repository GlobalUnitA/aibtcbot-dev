@extends('layouts.master')

@section('content')
<main class="container-fluid py-5 mb-5 px-4 position-relative">
    <div class="mb-4 d-flex gap-2 justify-content-between align-items-center">
        <h3 class="mb-0">{{ __('asset.deposit') }}</h3>
        <a href="{{ route('asset.deposit.list') }}">
            <h5 class="btn btn-header text-white border-0 m-0">{{ __('asset.deposit_list') }}</h5>
        </a>
    </div>
    <div class="mb-5 table-nstyle">
        <form method="POST" id="depositForm" action="{{ route('asset.deposit.confirm') }}">
            @csrf
            <fieldset>
                <legend class="fs-4 text-body mt-4 mb-2">{{ __('asset.select_deposit_asset_guide') }}</legend>     
                <div class="d-grid d-grid-col-2 mb-3"> 
                @foreach ($assets as $asset)
                    <div>
                        <input type="radio" class="btn-check" name="asset" value="{{ $asset->encrypted_id  }}" id="{{ $asset->coin->code }}" autocomplete="off">
                        <label class="btn btn-light w-100 p-4 rounded text-center fs-5 d-flex flex-column align-items-center" for="{{ $asset->coin->code }}">
                            <img src="{{ $asset->coin->image_urls[0] }}" width="40" alt="{{ $asset->coin->code }}" class="img-fluid mb-2">
                            {{ $asset->coin->name }}
                        </label>
                    </div>
                @endforeach
                </div>  
            </fieldset>            
            <div class="my-4">
                <label class="form-label text-body fs-4">{{ __('asset.deposit_amount_guide') }}</label>
                <input type="text" name="amount" id="amount" placeholder="0" class="form-control mb-3 text-body">
            </div>
            <div class="text-body mb-4">
                <h6 class="text-body mt-4">{{ __('asset.deposit_notice') }}</h6>
                <p class="mb-1">- {{ __('asset.deposit_min_amount') }}</p>
                <p class="mb-1">- {{ __('asset.deposit_arrival_period_guide') }}</p>
                <p class="mb-1">- {{ __('asset.deposit_trading_period_guide') }}</p>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-9 fs-4 mt-4 rounded-3">{{ __('asset.deposit') }}</button>
        </form>
    </div>    
</main>
@endsection

@push('message')
<div id="msg_deposit_asset" data-label="{{ __('asset.select_deposit_asset_guide') }}"></div>
<div id="msg_deposit_amount" data-label="{{ __('asset.deposit_amount_guide') }}"></div>
@endpush

@push('script')
<script src="{{ asset('js/asset/deposit.js') }}"></script>
@endpush