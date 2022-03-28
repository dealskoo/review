<?php

namespace Dealskoo\Review\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Seller\Facades\SellerMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Review\Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        $this->assertNotNull(AdminMenu::findBy('title', 'review::review.reviews'));
        $this->assertNotNull(SellerMenu::findBy('title', 'review::review.reviews'));
    }
}
