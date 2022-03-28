<?php

namespace Dealskoo\Review\Http\Controllers\Seller;

use Carbon\Carbon;
use Dealskoo\Review\Models\Review;
use Dealskoo\Seller\Http\Controllers\Controller as SellerController;
use Dealskoo\Tag\Facades\TagManager;
use Illuminate\Http\Request;

class ReviewController extends SellerController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('review::seller.review.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'title', 'country_id', 'can_comment', 'views', 'published_at', 'approved_at', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Review::where('seller_id', $request->user()->id);
        if ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%');
            $query->orWhere('slug', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $reviews = $query->skip($start)->take($limit)->get();
        $rows = [];
        foreach ($reviews as $review) {
            $row = [];
            $row[] = $review->id;
            $row[] = '<img src="' . $review->cover_url . '" alt="' . $review->title . '" title="' . $review->title . '" class="me-1"><p class="m-0 d-inline-block align-middle font-16">' . $review->title . '</p>';
            $row[] = $review->country->name;
            $row[] = $review->can_comment;
            $row[] = $review->views;
            $row[] = $review->published_at != null ? Carbon::parse($review->published_at)->format('Y-m-d H:i:s') : null;
            $row[] = $review->approved_at != null ? Carbon::parse($review->approved_at)->format('Y-m-d H:i:s') : null;
            $row[] = Carbon::parse($review->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($review->updated_at)->format('Y-m-d H:i:s');
            $edit_link = '<a href="' . route('seller.reviews.edit', $review) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="reviews_table" data-url="' . route('seller.reviews.destroy', $review) . '"> <i class="mdi mdi-delete"></i></a>';
            $row[] = $edit_link . $destroy_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function create(Request $request)
    {
        return view('review::seller.review.create');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('cover')) {
            $request->validate([
                'title' => ['required', 'string'],
                'cover' => ['required', 'image', 'max:1000'],
            ]);
        } else {
            $request->validate([
                'title' => ['required', 'string'],
            ]);
        }
        $review = new Review($request->only([
            'title',
            'content'
        ]));

        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = time() . '.' . $image->guessExtension();
            $path = $image->storeAs('review/images/' . date('Ymd'), $filename);
            $review->cover = $path;
        }
        $seller = $request->user();
        $review->seller_id = $seller->id;
        $review->country_id = $seller->country->id;
        $review->can_comment = $request->boolean('can_comment', false);
        $review->published_at = $request->boolean('published', false) ? Carbon::now() : null;
        $review->save();
        $tags = $request->input('tags', []);
        TagManager::sync($review, $tags);
        return redirect(route('seller.reviews.index'));
    }

    public function edit(Request $request, $id)
    {
        $review = Review::where('seller_id', $request->user()->id)->findOrFail($id);
        return view('review::seller.review.edit', ['review' => $review]);
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('cover')) {
            $request->validate([
                'title' => ['required', 'string'],
                'cover' => ['required', 'image', 'max:1000'],
            ]);
        } else {
            $request->validate([
                'title' => ['required', 'string'],
            ]);
        }
        $review = Review::where('seller_id', $request->user()->id)->findOrFail($id);
        $review->fill($request->only([
            'title',
            'content'
        ]));
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = time() . '.' . $image->guessExtension();
            $path = $image->storeAs('review/images/' . date('Ymd'), $filename);
            $review->cover = $path;
        }
        $review->can_comment = $request->boolean('can_comment', false);
        $review->published_at = $request->boolean('published', false) ? Carbon::now() : null;
        $review->save();
        $tags = $request->input('tags', []);
        TagManager::sync($review, $tags);
        return redirect(route('seller.reviews.index'));
    }

    public function destroy(Request $request, $id)
    {
        return ['status' => Review::where('seller_id', $request->user()->id)->where('id', $id)->delete()];
    }
}
