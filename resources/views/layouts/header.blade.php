
<div class="headerContainer container fixed-top" style="height: 1px; z-index: 1040;">
    <div class="offcanvas offcanvas-start vh-100 position-absolute" id="sidebar" tabindex="-1">
        <div class="offcanvas-header py-3" style="background-color:rgb(255 126 0);">
            <h1 class="offcanvas-title text-white flex-grow-1 text-center fs-7 my-1"><img src="{{ asset('/images/logos/logo_bit_w.svg') }}" height="26" alt="" class="me-2"></h1>
            <button type="button" class="btn-close flex-grow-0" data-bs-dismiss="offcanvas" style="filter: invert(1);"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="container-fluid px-1" style="">
                <div class="row text-center py-4 mx-1 text-decoration-none text-light">
                    <form method="POST" id="logoutForm" class="col px-1 cursor-pointer" action="{{ route('logout') }}" >
                        @csrf
                        <div onclick="logout();" class="icon-bg">
                            <img src="{{ asset('/images/icon/logout.svg') }}" class="mb-3">
                            <div class="fs-3">{{ __('auth.logout') }}</div>
                        </div>
                    </form>
                    <div class="col px-1 icon-bg">
                        <a class="nav-link text-inverse" href="{{ route('board.list', ['code' =>'notice'])}}">
                            <img src="{{ asset('/images/icon/notice.svg') }}" class="mb-3">
                            <div class="fs-3">{{ __('layout.notice') }}</div>
                        </a>
                    </div>
                    <div class="col px-1 icon-bg">
                        <a class="nav-link text-inverse" href="{{ route('board.list', ['code' =>'qna'])}}">
                            <img src="{{ asset('/images/icon/qna.svg') }}" class="mb-3">
                            <div class="fs-3">{{ __('layout.qna') }}</div>
                        </a>
                    </div>
                    <div class="col px-1 icon-bg">
                        <a class="nav-link text-inverse" href="{{ route('profile') }}">
                            <img src="{{ asset('/images/icon/myinfo.svg') }}" class="mb-3">
                            <div class="fs-3">{{ __('user.user_info') }}</div>
                        </a>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav" style="margin-bottom: 40px;">
                <li class="">
                    <a href="#" class="nav-link text-inverse fs-5 p-0 cursor-pointer px-3 border-bottom border-gray border-opacity-25" data-bs-toggle="collapse" data-bs-target="#language-collapse" aria-expanded="false">
                        <div class="nav-item d-flex justify-content-between align-items-center py-4 px-3">
                            <div class="align-items-cente d-flex"><img src="{{ asset('/images/icon/list_icon_language.svg') }}" class="list-icon me-2"><span>{{ __('Language') }}</span></div>
                            <i class="ti ti-chevron-up collapse-i"></i>
                        </div>
                    </a>
                    <div class="collapse border-bottom border-gray border-opacity-25" id="language-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal py-2 ps-5">
                            @foreach ($locales as $locale)
                                <li><a href="{{ route('change.language' ,['locale' => $locale['code']]) }}" class="link-gray d-inline-flex py-2 text-decoration-none fs-4">{{ $locale['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <a class="nav-link text-inverse fs-5 p-0 px-3 border-bottom border-gray border-opacity-25" href="{{ route('chart.aff') }}">
                    <li class="nav-item d-flex align-items-center py-4 px-3">
                        <img src="{{ asset('/images/icon/list_icon_down.svg') }}" class="list-icon me-2"><span>{{ __('layout.downline_tree') }}</span>
                    </li>
                </a>
                <a class="nav-link text-inverse fs-5 p-0 px-3 border-bottom border-gray border-opacity-25" href="{{ route('profile.referral', ['id' => auth()->user()->member->id]) }}">
                    <li class="nav-item d-flex align-items-center py-4 px-3">
                        <img src="{{ asset('/images/icon/list_icon_referral.svg') }}" class="list-icon me-2"><span>{{ __('asset.referrer_info') }}</span>
                    </li>
                </a>
                {{--
                <a class="nav-link text-inverse fs-5 p-0 border-bottom border-gray border-opacity-25" href="{{ route('chart.ref') }}">
                   <li class="nav-item d-flex align-items-center py-4 px-3">
                       <div class="ms-3">{{ __('layout.direct_referral_tree') }}</div>
                   </li>
               </a>
               <a class="nav-link text-inverse fs-5 p-0 border-bottom border-gray border-opacity-25" href="{{ route('profile.dashboard') }}">
                   <li class="nav-item d-flex align-items-center py-4 px-3">
                       <div class="ms-3">{{ __('user.dashboard') }}</div>
                   </li>
               </a>
               <a class="nav-link text-inverse fs-5 p-0 border-bottom border-gray border-opacity-25" href="{{ route('about') }}">
                   <li class="nav-item d-flex align-items-center py-4 px-3">
                       <div class="ms-3">{{ __('layout.company_about') }}</div>
                   </li>
               </a>
               --}}
                <a class="nav-link text-inverse fs-5 p-0 border-bottom border-gray border-opacity-25 px-3" href="{{ route('board.list', ['code' =>'product'])}}">
                    <li class="nav-item d-flex align-items-center py-4 px-3">
                        <img src="{{ asset('/images/icon/list_icon_product.svg') }}" class="list-icon me-2"><span>{{ __('layout.product_intro') }}</span>
                    </li>
                </a>
                <a class="nav-link text-inverse fs-5 p-0 border-bottom border-gray border-opacity-25 px-3" href="{{ route('board.list', ['code' =>'guide'])}}">
                    <li class="nav-item d-flex align-items-center py-4 px-3">
                        <img src="{{ asset('/images/icon/list_icon_guidebook.svg') }}" class="list-icon me-2"><span>{{ __('layout.guidebook') }}</span>
                    </li>
                </a>
                <a class="nav-link text-inverse fs-5 p-0 border-bottom border-gray border-opacity-25 px-3" href="{{ route('board.list', ['code' =>'terms'])}}">
                    <li class="nav-item d-flex align-items-center py-4 px-3">
                        <img src="{{ asset('/images/icon/list_icon_terms.svg') }}" class="list-icon me-2"><span>{{ __('layout.terms') }}</span>
                    </li>
                </a>
                <li class="px-3">
                    <div class="nav-item d-flex justify-content-end align-items-center fs-3 py-3">
                        <div class="ms-3 nav-link" style="color:#ff7e00;">{{ __('layout.dark_mode') }}</div>
                        <div class="form-check ps-3">
                            <button class="btn btn-dark swichbtn" id="themeBtn">On</button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<nav class="headerContainer container px-0 navbar bg-dark fixed-top py-3 border-start border-end border-start-sm-0 border-end-sm-0" style="height: 72px;">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center w-100">
            @if( !Request::is('home') )
            <a href="{{ url()->previous() }}" class="navbar-brand fs-6 nav-link text-inverse m-0 d-flex justify-content-center align-items-center" style="width: 54px;">
                <i class="ti ti-chevron-left fs-7" style="filter:  brightness(0) invert(1);"></i>
            </a>
            @else
            <div style="width: 54px;"></div>
            @endif
            <div class="flex-grow-1 text-center">
                <a class="navbar-brand fs-6 text-black fw-semibold m-0" href="{{ route('home') }}">
                    <h1 class="fs-7 m-0 p-0">
                        <img src="{{ asset('/images/logos/logo_bit_w.svg') }}" height="26" alt="">
                    </h1>
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" style="width: 54px;">
                <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
            </button>
        </div>
    </div>
</nav>
