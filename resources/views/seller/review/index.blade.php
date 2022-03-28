@extends('seller::layouts.panel')

@section('title',__('review::review.reviews_list'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.dashboard') }}">{{ __('seller::seller.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('review::review.reviews_list') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('review::review.reviews_list') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a href="{{ route('seller.reviews.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle me-2"></i> {{ __('review::review.add_review') }}
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="reviews_table" class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('review::review.id') }}</th>
                                <th>{{ __('review::review.title') }}</th>
                                <th>{{ __('review::review.country') }}</th>
                                <th>{{ __('review::review.can_comment') }}</th>
                                <th>{{ __('review::review.views') }}</th>
                                <th>{{ __('review::review.published_at') }}</th>
                                <th>{{ __('review::review.approved_at') }}</th>
                                <th>{{ __('review::review.created_at') }}</th>
                                <th>{{ __('review::review.updated_at') }}</th>
                                <th>{{ __('review::review.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            let table = $('#reviews_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('seller.reviews.index') }}",
                "language": language,
                "pageLength": pageLength,
                "columns": [
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': false},
                ],
                "order": [[0, "desc"]],
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    $('#reviews_table tr td:nth-child(2)').addClass('table-user');
                    $('#reviews_table tr td:nth-child(10)').addClass('table-action');
                    delete_listener();
                }
            });
            table.on('childRow.dt', function (e, row) {
                delete_listener();
            });
        });
    </script>
@endsection
