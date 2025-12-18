@extends('layouts.master')

@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" style="transform: translateY(-71px);">
    <div class="position-relative overflow-hidden min-vh-100 d-flex justify-content-center">
        <div class="d-flex justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="py-3 px-0">
                    <div class="card mb-0">
                        <div class="px-4 py-2 text-end">
                            <a href="{{ url()->previous() }}">
                                <button type="button" class="btn-close"></button>
                            </a>
                        </div>
                        <div class="card-body py-0 px-4">
                            <div class="mb-7">
                                <h3 class="mb-2">{{ __('auth.find_password') }}</h3>
                                <p class="mb-5">
                                    {{ __('auth.email_verification_guide_1') }}<br>
                                    {{ __('auth.email_verification_guide_2') }}
                                </p>
                            </div>
                            <div class="pb-3">
                                <h6 class="mb-4 key_color" >{{ __('auth.email_verification') }}</h6>
                                <form method="POST" action="{{ route('verify.code.send') }}" id="ajaxForm">
                                    @csrf
                                    <input type="hidden" name="mode" value="password"/>
                                    <div class="mb-4 form_line">
                                        <label for="inputAccount" class="form-label">{{ __('auth.login_id') }}</label>
                                        <input type="text" name="account" class="form-control required" required>
                                    </div>
                                    <div class="mb-4 form_line line_btn d-flex">
                                        <label for="inputAccount" class="form-label">{{ __('auth.email') }}</label>
                                        <input type="email" name="email" class="form-control required" required>
                                        <button type="submit" class="btn btn-primary rounded-5">{{ __('system.send') }}</button>
                                    </div>
                                </form>
                                <form method="POST" action="{{ route('verify.code.check') }}" id="verifyForm">
                                    @csrf
                                    <input type="hidden" name="mode" value="password"/>
                                    <div class="mb-4 form_line">
                                        <label for="inputEmail" class="form-label">{{ __('auth.verify_code') }}</label>
                                        <input type="text" name="code" class="form-control required" required>
                                        <button type="submit" class="btn btn-primary w-100 py-9 fs-4 mt-5 rounded-3">{{ __('auth.verify') }}</button>
                                    </div>
                                </form>
                            </div>
                            <!--div class="pb-3">
                                <h5 class="mb-3">휴대폰 인증</h5>
                                <form method="POST" action="" id="ajaxForm">
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