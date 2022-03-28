@extends('admin::layouts.panel')

@section('title',__('review::review.view_review'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('review::review.view_review') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('review::review.view_review') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $review->title }}</h3>
                    <div>
                        <span>{{ __('review::review.updated_at') }}: {{ \Carbon\Carbon::parse($review->updated_at)->diffForHumans() }}</span>
                        @isset($review->published_at)
                            <span
                                class="ms-2">{{ __('review::review.published_at') }}: {{ \Carbon\Carbon::parse($review->published_at)->diffForHumans() }}</span>
                        @endisset
                        <span class="ms-2">{{ __('review::review.country') }}: {{ $review->country->name }}</span>
                        @if($review->can_comment)
                            <span class="ms-2">{{ __('review::review.can_comment') }}</span>
                        @endif
                        <span class="ms-2">{{ __('review::review.views') }}: {{ $review->views }}</span>
                    </div>
                    <div class="mb-2">
                        @unless(empty($review->tags))
                            @foreach($review->tags as $tag)
                                <div class="badge bg-primary rounded-pill position-relative me-2 mt-2">
                                    {{ $tag->name }}
                                </div>
                            @endforeach
                        @endunless
                    </div>
                    <img src="{{ $review->cover_url }}" class="img-fluid mb-2">
                    <div class="mb-2">
                        @unless(empty($review->content))
                            {!! Str::markdown($review->content) !!}
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
