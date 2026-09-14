<?php

namespace TomatoPHP\FilamentCmsApi\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\TestCase as BaseTestCase;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use TomatoPHP\FilamentCms\FilamentCmsServiceProvider;
use TomatoPHP\FilamentCmsApi\FilamentCmsApiServiceProvider;
use TomatoPHP\FilamentCmsApi\Tests\Models\User;

#[WithEnv('DB_CONNECTION', 'testing')]
abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;

    protected function getPackageProviders($app): array
    {
        $providers = [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SchemasServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            MediaLibraryServiceProvider::class,
            FilamentCmsServiceProvider::class,
            FilamentCmsApiServiceProvider::class,
            AdminPanelProvider::class,
        ];

        sort($providers);

        return $providers;
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('media-library.disk_name', 'public');
    }
}
