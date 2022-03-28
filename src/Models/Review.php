<?php

namespace Dealskoo\Review\Models;

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
    use HasFactory, HasCountry, HasSeller, Taggable, Commentable, SoftDeletes;

    protected $appends = [
        'cover_url'
    ];

    protected $fillable = [
        'slug',
        'title',
        'cover',
        'content',
        'published_at',
        'approved',
        'can_comment',
        'views',
        'country_id',
        'seller_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'approved' => 'boolean',
        'can_comment' => 'boolean',
    ];

    public function getCoverUrlAttribute()
    {
        return empty($this->cover) ? '' : Storage::url($this->cover);
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->whereNotNull('published_at');
    }

    public function scopeApproved(Builder $builder)
    {
        return $builder->where('approved', true);
    }
}
