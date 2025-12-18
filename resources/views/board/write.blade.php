@extends('layouts.master')

@section('content')
<main class="container-fluid py-5 mb-5 px-4">
    @if($mode == 'write')
    <form method="POST" action="{{ route('board.write') }}" id="boardForm">
    @else
    <form method="POST" action="{{ route('board.modify') }}" id="boardForm">
    @endif
        @csrf
        <input type="hidden" name="board_id" value="{{ $board->id }}">
        @if($mode == 'modify')
        <input type="hidden" name="post_id" value="{{ $view->id }}">
        @endif
        <div class="mb-4">
            <h3 class="text-center">
                @if($mode == 'write')
                {{ $board->locale_name }}
                @else
                {{ $board->locale_name }}
                @endif
            </h3>
        </div>
        <div class="mb-4 form_line keycolor">
            <label for="subject" class="form-label fw-bold style-no">{{ __('system.title') }}</label>
            <input type="text" class="form-control" id="subject" name="subject" value="{{ $view->subject ?? '' }}" >
        </div>
        <div class="mb-4 form_line keycolor">
            <label for="content" class="form-label fw-bold">{{ __('system.contents') }}</label>
            <textarea name="content" id="content" class="form-control" rows="12"></textarea>
        </div>
        <div class="mb-4 form_line keycolor">
            <label for="content" class="form-label fw-bold">{{ __('etc.image_upload') }}</label>
            <div class="d-flex upbox_line gap-2">
                <div class="preview-box">
                    <label style="display: block; width: 100%; height: 100%; position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon-plus">
                            <path d="M256 512a256 256 0 1 0 0-512 256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                        </svg>
                        <img src="" class="img-preview d-none cursor-pointer">
                        <input type="file" name="image_urls[0]" class="file-input d-none" accept="image/jpeg, image/png">
                        <input type="hidden" name="file_key[]">
                    </label>
                </div>
                <div class="preview-box">
                    <label style="display: block; width: 100%; height: 100%; position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon-plus">
                            <path d="M256 512a256 256 0 1 0 0-512 256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                        </svg>
                        <img src="" class="img-preview d-none cursor-pointer">
                        <input type="file" name="image_urls[1]" class="file-input d-none" accept="image/jpeg, image/png">
                        <input type="hidden" name="file_key[]">
                    </label>
                </div>
                <div class="preview-box">
                    <label style="display: block; width: 100%; height: 100%; position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon-plus">
                            <path d="M256 512a256 256 0 1 0 0-512 256 256 0 1 0 0 512zM232 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                        </svg>
                        <img src="" class="img-preview d-none cursor-pointer">
                        <input type="file" name="image_urls[2]" class="file-input d-none" accept="image/jpeg, image/png">
                        <input type="hidden" name="file_key[]">
                    </label>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="d-flex justify-content-start flex-column w-100 align-items-start gap-4">
                @if($mode == 'write')
                <button type="submit" class="btn btn-primary w-100 py-9 fs-4 mt-2 rounded-3">{{ __('layout.submit_request') }}</button>
                @else
                <button type="submit" class="btn btn-primary w-100 py-9 fs-4 mt-5 rounded-3">{{ __('system.modify') }}</button>
                @endif
                <a href="{{ route('board.list', ['code' => $board->board_code ])}}" class="btn btn-inverse">{{ __('system.list') }}</a>
            </div>
        </div>
    </form>
</main>
@endsection

@push('message')
<div id="msg_input_title" data-label="{{ __('layout.input_title_notice') }}"></div>
<div id="msg_input_contents" data-label="{{ __('layout.input_contents_notice') }}"></div>
@endpush

@push('script')
    <script src="{{ asset('js/board/post.js') }}"></script>
@endpush
