<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use TomatoPHP\FilamentCmsApi\FilamentCmsApiPlugin;

it('registers the plugin on the panel', function () {
    expect(Filament::getPanel('admin')->getPlugin('filament-cms-api'))
        ->toBeInstanceOf(FilamentCmsApiPlugin::class);
});

it('registers the api routes under the configured prefix', function () {
    expect(Route::has('filament-cms-api.posts.index'))->toBeTrue()
        ->and(Route::has('filament-cms-api.posts.show'))->toBeTrue()
        ->and(Route::has('filament-cms-api.categories.index'))->toBeTrue()
        ->and(Route::has('filament-cms-api.categories.show'))->toBeTrue()
        ->and(route('filament-cms-api.posts.index', absolute: false))->toBe('/api/cms/posts');
});

it('merges the package config', function () {
    expect(config('filament-cms-api.per_page'))->toBe(15)
        ->and(config('filament-cms-api.middleware'))->toBe(['api']);
});
