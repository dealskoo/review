<?php

namespace Dealskoo\Review\Http\Controllers\Admin;

use Carbon\Carbon;
use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Review\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('reviews.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('review::admin.review.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'title', 'seller_id', 'country_id', 'can_comment', 'views', 'published_at', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Review::query();
        if ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%');
            $query->orWhere('slug', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $reviews = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('reviews.show');
        $can_edit = $request->user()->canDo('reviews.edit');
        foreach ($reviews as $review) {
            $row = [];
            $row[] = $review->id;
            $row[] = '<img src="' . $review->cover_url . '" alt="' . $review->title . '" title="' . $review->title . '" class="me-1"><p class="m-0 d-inline-block align-middle font-16">' . $review->title . '</p>';
            $row[] = '<img src="' . $review->seller->avatar_url . '" alt="' . $review->seller->name . '" title="' . $review->seller->name . '" class="me-1"><p class="m-0 d-inline-block align-middle font-16">' . $review->seller->name . '</p>';
            $row[] = $review->country->name;
            $row[] = $review->can_comment;
            $row[] = $review->views;
            $row[] = $review->published_at != null ? Carbon::parse($review->published_at)->format('Y-m-d H:i:s') : null;
            $row[] = Carbon::parse($review->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($review->updated_at)->format('Y-m-d H:i:s');
            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.reviews.show', $review) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.reviews.edit', $review) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $row[] = $view_link . $edit_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function show(Request $request, $id)
    {

    }

    public function edit(Request $request, $id)
    {

    }

    public function update(Request $request, $id)
    {

    }
}
