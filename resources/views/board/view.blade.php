@extends('layouts.master')

@section('content')
<main class="container-fluid py-5 mb-5 px-4">
    <div class="d-flex justify-content-between align-items-start flex-column mb-1">
        @if($board->board_code == 'notice')
        <span class="badge bg-info mb-1">{{ __('layout.notice') }}</span>
        @endif
        <h3 class="mb-0">{{ $view->subject }}</h3>
    </div>
    <div class="post-info py-2 text-end">
        <i class="bi bi-clock me-1" style="vertical-align: middle;"></i><span class="m-0">{{ __('system.created_at') }} : {{ $view->created_at->format('Y-m-d') }}</span>
    </div>
    <div class="post-content py-4 px-2 table-nstyle">
    @if ($board->is_popup == 'y')
        {!! $view->content !!}
    @else
        {!! nl2br(e($view->content)) !!}
    @endif
    </div>
    @if($download_urls)
    <div class="text-center align-middle">
        @foreach($download_urls as $val)
            <div class="mb-3">
                <a href="{{ $val }}">
                    <img src="{{ $val }}" class="img-fluid">
                </a>
            </div>
        @endforeach
    </div>
    @endif
    @if($board->is_comment == 'y')
    @if(!$comments->isEmpty())
    <div class="bd-top-g content-d">
        <div class="tabbox_bg mt-2">
            <div class="d-flex justify-content-between align-items-center ps-0">
                <h6>{{ __('layout.comment_list') }}</h6>
            </div>
            @endif
            <form method="POST" action="{{ route('board.comment') }}" id="ajaxForm">
                @csrf
                <input type="hidden" name="board_id" value="{{ $board->id }}"/>
                <input type="hidden" name="post_id" value="{{ $view->id }}"/>
                <div class="d-flex flex-column justify-content- align-items-end gap-2">
                    <textarea name="content" class="form-control flex-grow-1 w-100 bg-white placeholder-w border-0 h-75px" id="content" rows="3" placeholder="{{ __('layout.comment_guide') }}" style="resize: none;color:#333;"></textarea>
                    <button type="submit" class="btn btn-primary mt-1">{{ __('system.write') }}</button>
                </div>
            </form>
            @endif
        </div>
    </div>
    <div class="list-group px-2 mt-3">
    @foreach($comments as $comment)
        <div class="list-group-item list-item-line">
            <i class="ti ti-corner-down-right"></i>
            <strong>{{ $comment->user ? $comment->user->name : $comment->admin->name }}</strong>
            @if($comment->admin)
                <span class="badge bg-danger">{{ __('system.admin') }}</span>
            @endif
            <div class="ms-4">
                <p>{!! nl2br(e($comment->content)) !!}</p>
                <small>{{ $comment->created_at->format('Y-m-d h:i:s') }}</small>
            </div>
        </div>
    @endforeach
    </div>
    <hr>
    <div class="d-flex justify-content-start align-items-center mb-5">
        <div>
            <a href="{{ route('board.list', ['code' => $board->board_code ])}}" class="btn btn-inverse">{{ __('system.list') }}</a>
        </div>
    </div>
</main>
@endsection

@push('script')
@endpush
