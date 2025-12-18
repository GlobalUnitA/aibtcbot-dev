@extends('layouts.master')

@section('content')
<main class="container-fluid py-5 mb-5 px-4">
    <div class="mb-4">
        <h3>{{ $data['coin_name'] }} {{ __('asset.asset_detail') }}</h3>
    </div>
    <div class="g-3 mb-5 content-d mt-0">
        <div class="p-4 text-body mb-4 tabbox_bg">
            <div class="d-flex justify-content-between align-items-center">
                <p class="fs-4 m-0 key_color">{{ __('asset.total_asset') }}</p>
                <h3 class="fs-6 mb-1 key_color">{{ $data['balance'] }}</h3>
            </div>            
        </div>
        @if($list->isNotEmpty())
        <div class="table-responsive pb-5 table-nstyle">
            <table class="table">
                <thead class="mb-2">
                    <tr>
                        <th>{{ __('system.date') }}</th>
                        <th>{{ __('system.amount') }}</th>
                        <th>{{ __('system.category') }}</th>
                    </tr>
                </thead>
                <tbody id="loadMoreContainer">              
                    @foreach($list as $key => $val)
                    <tr>
                        <td>{{ date_format($val->created_at, 'Y-m-d') }}</td>
                        <td>{{ $val->amount }}</td>
                        <td>{{ $val->type_text }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table> 
            @if($has_more)
            <a href="{{ route('asset.list',['id' => $data['encrypted_id']]) }}" class="btn btn-outline-primary w-100 py-2 my-4 fs-4">{{ __('system.load_more') }}</a>
            @endif
        </div>
    @endif
    </div>
</main>
@endsection
