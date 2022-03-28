<?php

namespace Dealskoo\Review\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Dealskoo\Review\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Review\Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.reviews.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.reviews.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $review = Review::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.reviews.show', $review));
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $review = Review::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.reviews.edit', $review));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $review = Review::factory()->create();
        $review1 = Review::factory()->make();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.reviews.update', $review), $review1->only([
            'title'
        ]));
        $response->assertStatus(302);
    }
}
