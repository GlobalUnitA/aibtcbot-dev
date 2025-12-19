@extends('layouts.master')

@section('content')
<div class="container py-5 mb-5 px-4">
    <div class="mb-4">
        <h3>{{ __('mining.mining_list') }}</h3>
    </div>
    @foreach($minings as $mining)
    <div class="table-responsive overflow-x-auto pb-5 table-nstyle">
        <table class="table break-keep-all">
            <thead class="mb-2">
                <tr>
                    <th class="text-center" colspan="3">{{ $mining->product->mining_locale_name }}</th>
                </tr>
                <tr>
                    <th>{{ __('system.date') }}</th>
                    <th>{{ __('mining.node_amount') }}</th>
                    <th>{{ __('mining.collateral_amount') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ date_format($mining->created_at, 'Y-m-d h:i:s') }}</td>
                    <td>{{ $mining->entry_amount }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    @endforeach
</div>
@endsection
