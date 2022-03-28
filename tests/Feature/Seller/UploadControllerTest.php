<?php

namespace Dealskoo\Review\Tests\Feature\Seller;

use Dealskoo\Seller\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Review\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_upload()
    {
        Storage::fake();
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->post(route('seller.reviews.upload'), [
            'editormd-image-file' => UploadedFile::fake()->image('file.jpg')
        ]);
        $response->assertStatus(200);
        $url = json_decode($response->content())->url;
        $filename = basename($url);
        Storage::assertExists('review/images/' . date('Ymd') . '/' . $filename);
    }
}
