@extends('admin::layouts.panel')
@section('title',__('review::review.edit_review'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('review::review.edit_review') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('review::review.edit_review') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.reviews.update',$review) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if(!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if(!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" id="title" name="title" required
                                               value="{{ old('title',$review->title) }}" autofocus tabindex="1"
                                               placeholder="{{ __('review::review.title_placeholder') }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" id="slug" name="slug" required
                                               value="{{ old('slug',$review->slug) }}" tabindex="2"
                                               placeholder="{{ __('review::review.slug_placeholder') }}">
                                    </div>
                                    <div class="col-12 markdown-body">
                                        @unless(empty($review->content))
                                            {!! Str::markdown($review->content) !!}
                                        @endunless
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="cover-box">
                                            <img src="{{ $review->cover_url }}"
                                                 class="img-thumbnail file-pic file-cover">
                                            <div class="upload-image">
                                                <i class="mdi mdi-cloud-upload upload-btn upload-cover-btn"></i>
                                                <input class="file-input" name="cover" type="file" tabindex="4"
                                                       accept="image/*"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control tag-input" id="tag" name="tag"
                                               value="{{ old('tag') }}" tabindex="6"
                                               placeholder="{{ __('review::review.tag_placeholder') }}">
                                        <div class="mt-1 tags-box">
                                            @unless(empty(old('tags')))
                                                @foreach(old('tags') as $tag)
                                                    <div
                                                        class="badge bg-primary rounded-pill position-relative me-2 mt-2 tag-badge">
                                                        {{ $tag }}<input type="hidden" name="tags[]"
                                                                         value="{{ $tag }}"><span
                                                            class="position-absolute top-0 start-100 translate-middle bg-danger border border-light rounded-circle mdi mdi-close tag-remove"></span>
                                                    </div>
                                                @endforeach
                                            @else
                                                @unless(empty($review->tags))
                                                    @foreach($review->tags as $tag)
                                                        <div
                                                            class="badge bg-primary rounded-pill position-relative me-2 mt-2 tag-badge">
                                                            {{ $tag->name }}<input type="hidden" name="tags[]"
                                                                                   value="{{ $tag->name }}"><span
                                                                class="position-absolute top-0 start-100 translate-middle bg-danger border border-light rounded-circle mdi mdi-close tag-remove"></span>
                                                        </div>
                                                    @endforeach
                                                @endunless
                                            @endunless
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="can_comment"
                                                   name="can_comment" tabindex="7" value="1"
                                                   @if(old('can_comment') || $review->can_comment) checked @endif>
                                            <label for="can_comment"
                                                   class="form-check-label">{{ __('review::review.can_comment') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="published"
                                                   name="published" tabindex="8" value="1"
                                                   @if(old('published') || $review->published_at !=null) checked @endif>
                                            <label for="published"
                                                   class="form-check-label">{{ __('review::review.published') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="approved"
                                                   name="approved" tabindex="8" value="1"
                                                   @if(old('approved') || $review->approved_at !=null) checked @endif>
                                            <label for="approved"
                                                   class="form-check-label">{{ __('review::review.approved') }}</label>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success mt-2" tabindex="9"><i
                                                class="mdi mdi-content-save"></i> {{ __('admin::admin.save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="{{ asset('/vendor/admin/css/vendor/github-markdown-light.css') }}" rel="stylesheet" type="text/css"/>
@endsection
