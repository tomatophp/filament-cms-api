<?php

use Illuminate\Support\Facades\Route;
use TomatoPHP\FilamentCmsApi\Http\Controllers\CategoryController;
use TomatoPHP\FilamentCmsApi\Http\Controllers\PostController;

Route::middleware(config('filament-cms-api.middleware', ['api']))
    ->prefix(config('filament-cms-api.prefix', 'api/cms'))
    ->name('filament-cms-api.')
    ->group(function () {
        Route::get('posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('posts/{slug}', [PostController::class, 'show'])->name('posts.show');
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
    });
