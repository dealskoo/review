<?php

namespace Dealskoo\Review\Models;

use Dealskoo\Admin\Traits\HasSlug;
use Dealskoo\Comment\Traits\Commentable;
use Dealskoo\Country\Traits\HasCountry;
use Dealskoo\Seller\Traits\HasSeller;
use Dealskoo\Tag\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Review extends Model
{
    use HasFactory, HasSlug, HasCountry, HasSeller, Taggable, Commentable, SoftDeletes;

    protected $appends = [
        'cover_url',
        'summary'
    ];

    protected $fillable = [
        'slug',
        'title',
        'cover',
        'content',
        'published_at',
        'approved_at',
        'can_comment',
        'views',
        'country_id',
        'seller_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'approved_at' => 'datetime',
        'can_comment' => 'boolean',
    ];

    public function getCoverUrlAttribute()
    {
        return empty($this->cover) ? asset(config('review.default_cover')) : Storage::url($this->cover);
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->whereNotNull('published_at');
    }

    public function scopeApproved(Builder $builder)
    {
        return $builder->whereNotNull('approved_at');
    }

    public function getSummaryAttribute()
    {
        return Str::limit(strip_tags(Str::markdown($this->content)), 100);
    }
}
