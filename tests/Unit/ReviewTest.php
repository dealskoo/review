<?php

namespace Dealskoo\Review\Tests\Unit;

use Dealskoo\Review\Models\Review;
use Dealskoo\Review\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_cover_url()
    {
        $review = Review::factory()->create();
        $review->cover = 'cover.png';
        $this->assertEquals($review->cover_url, Storage::url($review->cover));
    }

    public function test_with_published()
    {
        $count = 2;
        Review::factory()->create();
        Review::factory()->count($count)->published()->create();
        $this->assertEquals($count, Review::published()->count());
    }

    public function test_with_approved()
    {
        $count = 2;
        Review::factory()->create();
        Review::factory()->count($count)->approved()->create();
        $this->assertEquals($count, Review::approved()->count());
    }
}
