<?php

use Dealskoo\Review\Http\Controllers\Seller\ReviewController;
use Dealskoo\Review\Http\Controllers\Seller\UploadController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'seller_locale'])->prefix(config('seller.route.prefix'))->name('seller.')->group(function () {

    Route::middleware(['guest:seller'])->group(function () {

    });

    Route::middleware(['auth:seller', 'verified:seller.verification.notice', 'seller_active'])->group(function () {

        Route::resource('reviews', ReviewController::class)->except(['show']);
        Route::post('/reviews/upload', [UploadController::class, 'upload'])->name('reviews.upload');

        Route::middleware(['password.confirm:seller.password.confirm'])->group(function () {

        });
    });
});
