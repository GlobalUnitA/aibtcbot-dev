@extends('layouts.master')

@section('content')
<main class="container-fluid py-5 px-4">
    <div class="mb-7">
        <h3>{{ __('auth.reset_password') }}</h3>    
    </div>
    <form method="POST" action="{{ route('profile.password.update') }}" id="ajaxForm" class="mb-5">
        @csrf
        <input type="hidden" name="id" value="{{ $view->user_id }}">
        <div class="pt-4">
            <div class="d-flex form_line w-100 mb-4">
                <div class="form-label">{{ __('auth.login_id') }}</div>
                <div class="form-control input_like">{{ $view->account }}</div>
            </div>
            <div class="d-flex form_line w-100 mb-4">
                <div class="form-label">{{ __('auth.current_password') }}</div>
                <input type="password" name="current_password" class="form-control required" required>
            </div>
            <div class="d-flex form_line w-100 mb-1">
                <div class="form-label">{{ __('auth.new_password') }}</div>
                <input type="password" name="password"  id="inputPassword1" class="form-control required" required>
            </div>
            <div class="form-text mb-3">{{ __('auth.password_guide') }}</div>
            <div class="d-flex form_line w-100 mb-1">
                <div class="form-label">{{ __('auth.confirm_password') }}</div>
                <input type="password" name="password_confirmation" id="inputPassword2" class="form-control required" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-9 fs-4 mt-4 rounded-3">{{ __('auth.reset_password') }}</button>
    </form>
</main>
<form method="POST" id="confirmForm" >
    @csrf
</form>
@endsection

@push('message')
<div id="msg_password_guide" data-label="{{ __('auth.password_guide') }}"></div>
@endpush

@push('script')
<script src="{{ asset('js/profile/password.js') }}"></script>
@endpush