<?php

namespace Dealskoo\Review\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Review\Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        $this->assertNotNull(PermissionManager::getPermission('reviews.index'));
        $this->assertNotNull(PermissionManager::getPermission('reviews.show'));
        $this->assertNotNull(PermissionManager::getPermission('reviews.edit'));
    }
}
