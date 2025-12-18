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
                            <div class="mb-0">
                                <h3 class="mb-5" >{{ __('auth.reset_password') }}</h3>
                                <form method="POST" action="{{ route('password.update') }}" id="ajaxForm">
                                    @csrf
                                    <div class="pb-3 from_line">
                                        <label for="inputAccount" class="form-label">{{ __('auth.new_password') }}</label>
                                        <input type="password" name="password" class="form-control required" required>
                                        </div>
                                        <div class="form-text">{{ __('auth.password_guide') }}</div>
                                    </div>
                                    <div class="form_line">
                                        <label for="inputAccount" class="form-label">{{ __('auth.confirm_password') }}</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" class="form-control required" required>
                                        </div>
                                        <div class="form-text">{{ __('auth.password_guide') }}</div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-9 fs-4 mt-5 rounded-3">{{ __('system.change') }}</button>    
                                </form>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
