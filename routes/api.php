<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('api/pages')->name('api.pages.')->group(function () {
    Route::get('/', [\TomatoPHP\FilamentCms\Http\Controllers\PageController::class, 'index'])->name('index');
    Route::get('/{model}', [\TomatoPHP\FilamentCms\Http\Controllers\PageController::class, 'show'])->name('show');
});
