<footer class="footerContainer container px-0 fixed-bottom border-start border-end border-start-sm-0 border-end-sm-0 border-top">
    <div class="container">
        <div class="row text-center py-2 mx-0">
            <div class="col px-1 ">
                <a href="{{ route('register',['mid' => 'U'.Auth::user()->id]) }}" class="text-decoration-none text-dark d-block">
                    <img src="{{ asset('/images/icon/nav1_register.png') }}" class="m-register">
                    <div class="fs-2">{{ __('auth.join') }}</div>
                </a>
            </div>
            <div class="col px-1">
                <a href="#" class="text-decoration-none text-dark copyBtn d-block" data-copy="{{ route('register', ['mid' => 'U'.Auth::user()->id]) }}">
                    <img src="{{ asset('/images/icon/nav2_link.png') }}" class="m-link">
                    <div class="fs-2">{{ __('layout.referral_link') }}</div>
                </a>
            </div>
            {{-- 가입하기 및 추천링크 기능 조건 is_valid 유무 분기
            <div class="col px-1 ">
                <span style="cursor:not-allowed">
                    <img src="{{ asset('/images/icon/nav1_register.png') }}" class="m-register" >
                    <div class="fs-2 text-decoration-none text-dark text-opacity-30">{{ __('auth.join') }}</div>
                </span>
            </div>
            <div class="col px-1">
                <span style="cursor:not-allowed">
                    <img src="{{ asset('/images/icon/nav2_link.png') }}" class=" m-link" >
                    <div class="fs-2 text-decoration-none text-dark text-opacity-30">{{ __('layout.referral_link') }}</div>
                </span>
            </div>
            --}}
            <div class="col px-1">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark d-block">
                    <img src="{{ asset('/images/icon/nav3_home.png') }}" class="m-home">
                    <div class="fs-2">{{ __('layout.home') }}</div>
                </a>
            </div>
            <div class="col px-1">
                <a href="{{ route('profile.dashboard') }}" class="text-decoration-none text-dark d-block">
                    <img src="{{ asset('/images/icon/nav4_dashboard.png') }}" class="m-dashboard">
                    <div class="fs-2">{{ __('user.dashboard') }}</div>
                </a>
            </div>
            <div class="col px-1">
                <!--a href="{{ route('board.list', ['code' => 'terms']) }}" class="text-decoration-none text-dark"-->
                <a href="#" class="text-decoration-none text-dark d-block" onclick="alertModal('{{ __('system.coming_soon_notice') }}')">
                    <img src="{{ asset('/images/icon/nav5_terms.png') }}" class="m-terms">
                    <div class="fs-2">{{ __('layout.terms') }}</div>
                </a>
            </div>
        </div>
    </div>
</footer>
