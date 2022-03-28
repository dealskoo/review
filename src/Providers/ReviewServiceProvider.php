<?php

namespace Dealskoo\Review\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Dealskoo\Seller\Facades\SellerMenu;
use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/review.php', 'review');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../config/review.php' => config_path('review.php')
            ], 'config');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/review')
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/seller.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'review');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'review');

        AdminMenu::route('admin.reviews.index', 'review::review.reviews', [], ['icon' => 'uil-notes', 'permission' => 'reviews.index'])->order(4);

        PermissionManager::add(new Permission('reviews.index', 'Review Lists'));
        PermissionManager::add(new Permission('reviews.show', 'View Review'), 'reviews.index');
        PermissionManager::add(new Permission('reviews.edit', 'Edit Review'), 'reviews.index');

        SellerMenu::route('seller.reviews.index', 'review::review.reviews', [], ['icon' => 'uil-notes me-1'])->order(4);
    }
}
