<?php

namespace TomatoPHP\FilamentCmsApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * Translatable fields are returned in the app locale; ?locale=xx switches it per request.
     */
    protected function applyLocale(Request $request): void
    {
        $locale = $request->query('locale');

        if (is_string($locale) && preg_match('/^[A-Za-z]{2,3}([_-][A-Za-z0-9]{2,8})?$/', $locale)) {
            app()->setLocale($locale);
        }
    }

    protected function perPage(Request $request): int
    {
        $default = (int) config('filament-cms-api.per_page', 15);
        $max = (int) config('filament-cms-api.max_per_page', 100);

        return max(1, min($request->integer('per_page', $default), $max));
    }
}
