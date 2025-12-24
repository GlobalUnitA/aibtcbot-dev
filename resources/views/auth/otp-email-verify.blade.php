@extends('layouts.master')

@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden d-flex justify-content-center">
        <div class="d-flex justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="py-0 px-0">
                    <div class="card mb-0">
                        <div class="card-body px-4 py-5">
                            <div class="mb-3">
                                <h3>{{ __('system.security') }}</h3>
                            </div>
                            <div class="pb-3 pt-4 register_n">
                                <h5 class="mb-4"> {{ __('auth.identity_verification') }} ({{ __('auth.email_verification') }})</h5>
                                <form method="POST" action="{{ route('verify.code.send') }}" id="ajaxForm">
                                    @csrf
                                    <input type="hidden" name="mode" value="account"/>
                                    <div class="mb-4 d-flex gap-2">
                                        <div class="d-flex form_line line_btn w-100">
                                            <label for="inputAccount" class="form-label">{{ __('auth.email') }}</label>
                                            <input type="email" name="email" class="form-control required style-no-bon" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary rounded-5" style="width: auto;max-width: 175px;flex-shrink: 0;">{{ __('system.send') }}</button>
                                    </div>
                                </form>
                                <form method="POST" action="  {{ route('verify.code.check') }}" id="verifyForm">
                                    @csrf
                                    <input type="hidden" name="mode" value="otp"/>
                                    <div class="mb-4 form_line">
                                        <label for="inputEmail" class="form-label">{{ __('auth.verify_code') }}</label>
                                        <input type="text" name="code" class="form-control required" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-9 fs-4 mt-4 rounded-3">{{ __('auth.verify') }}</button>
                                </form>
                            </div>
                            <!--div class="pb-3">
                                <h5 class="mb-3">휴대폰 인증</h5>
                                <form method="POST" id="ajaxForm" action="">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="inputAccount" class="form-label">휴대폰</label>
                                        <div class="input-group">
                                            <input type="text" name="account" class="form-control required"  id="inputAccount" required>
                                            <button type="button"  id="copyBtn" class="btn btn-primary rounded-end-3">발송</button>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label for="inputEmail" class="form-label">인증번호</label>
                                        <input type="email" name="email" class="form-control required"  id="inputEmail" aria-describedby="emailHelp" required>
                                    </div>
                                </form>
                            </div-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('js/auth/verify.js') }}"></script>
@endpush
