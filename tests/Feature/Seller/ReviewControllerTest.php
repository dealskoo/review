<?php

namespace Dealskoo\Review\Tests\Feature\Seller;

use Dealskoo\Review\Models\Review;
use Dealskoo\Seller\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Review\Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.reviews.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.reviews.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.reviews.create'));
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $seller = Seller::factory()->create();
        $review = Review::factory()->make();
        $response = $this->actingAs($seller, 'seller')->post(route('seller.reviews.store'), $review->only([
            'title',
            'content'
        ]));
        $response->assertStatus(302);
    }

    public function test_edit()
    {
        $seller = Seller::factory()->create();
        $review = Review::factory()->create(['seller_id' => $seller->id]);
        $response = $this->actingAs($seller, 'seller')->get(route('seller.reviews.edit', $review));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $seller = Seller::factory()->create();
        $review = Review::factory()->create(['seller_id' => $seller->id, 'country_id' => $seller->country->id]);
        $review1 = Review::factory()->make();
        $response = $this->actingAs($seller, 'seller')->put(route('seller.reviews.update', $review), $review1->only([
            'title',
            'content'
        ]));
        $response->assertStatus(302);
    }

    public function test_destroy()
    {
        $seller = Seller::factory()->create();
        $review = Review::factory()->create(['seller_id' => $seller->id]);
        $response = $this->actingAs($seller, 'seller')->delete(route('seller.reviews.destroy', $review));
        $response->assertStatus(200);
    }
}
