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
                            <div class="pb-3">
                                <h5 class="mb-3" >{{ __('auth.find_id_result') }}</h5>
                                <p class="fs-4">{{ __('auth.find_id_result_guide_1') }}<strong class="fs-5 text-primary">({{ $user_id }})</strong> {{ __('auth.find_id_result_guide_2') }}</p>   
                                <a type="button" class="btn btn-primary w-100 py-9 fs-4 mt-4 rounded-3" href="{{ route('password.request') }}">{{ __('auth.find_password') }}</a>
                                
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
