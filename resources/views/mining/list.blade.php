@extends('layouts.master')

@section('content')
<div class="container py-5">
    <h2 class="mb-3 text-center">{{ __('mining.mining_list') }}</h2>
    <hr>
    @foreach($minings as $mining)
    <div class="table-responsive overflow-x-auto pt-3">
        <table class="table table-striped table-bordered break-keep-all">
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
