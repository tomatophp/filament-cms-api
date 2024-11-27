<?php

namespace TomatoPHP\FilamentCmsApi;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentCmsApiPlugin implements Plugin
{

    public function getId(): string
    {
        return 'filament-cms-api';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): self
    {
        return new FilamentCmsApiPlugin;
    }
}
