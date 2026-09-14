<?php

namespace TomatoPHP\FilamentCmsApi;

use Illuminate\Support\ServiceProvider;

class FilamentCmsApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register Config file
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-cms-api.php', 'filament-cms-api');
    }

    public function boot(): void
    {
        // Publish Config
        $this->publishes([
            __DIR__ . '/../config/filament-cms-api.php' => config_path('filament-cms-api.php'),
        ], 'filament-cms-api-config');

        // Register Langs
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-cms-api');

        // Publish Lang
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('lang/vendor/filament-cms-api'),
        ], 'filament-cms-api-lang');

        // Register Routes
        if (config('filament-cms-api.active', true)) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        }
    }
}
