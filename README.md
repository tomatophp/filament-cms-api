![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-cms-api/master/arts/fadymondy-tomato-cms-api.jpg)

# Filament CMS Builder APIs

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-cms-api/version.svg)](https://packagist.org/packages/tomatophp/filament-cms-api)
[![License](https://poser.pugx.org/tomatophp/filament-cms-api/license.svg)](https://packagist.org/packages/tomatophp/filament-cms-api)
[![Downloads](https://poser.pugx.org/tomatophp/filament-cms-api/d/total.svg)](https://packagist.org/packages/tomatophp/filament-cms-api)
[![Tests](https://github.com/tomatophp/filament-cms-api/actions/workflows/tests.yml/badge.svg)](https://github.com/tomatophp/filament-cms-api/actions/workflows/tests.yml)

Read-only JSON API for [TomatoPHP Filament CMS](https://github.com/tomatophp/filament-cms) posts and categories.

## Requirements

| Package version | Filament CMS | Filament | Laravel     | PHP  |
|-----------------|--------------|----------|-------------|------|
| 5.x             | 5.x          | 5.x      | 12.x, 13.x  | 8.2+ |

## Installation

```bash
composer require tomatophp/filament-cms-api
```

The routes are registered automatically. Registering the plugin on a panel is optional:

```php
->plugin(\TomatoPHP\FilamentCmsApi\FilamentCmsApiPlugin::make())
```

## Endpoints

All endpoints are `GET`, return [API resources](https://laravel.com/docs/eloquent-resources) and live under the `api/cms` prefix.

| Endpoint | Description |
|----------|-------------|
| `/api/cms/posts` | Published posts (paginated). Filters: `type`, `category` (slug), `tag` (slug), `trend=1`, `search`, `per_page` |
| `/api/cms/posts/{slug}` | A published post with its categories, tags and images |
| `/api/cms/categories` | Active categories (paginated). Filters: `for`, `type`, `menu=1`, `root=1`, `per_page` |
| `/api/cms/categories/{slug}` | An active category with its active children |

Only posts with `is_published` and a publish date in the past are returned. Translatable fields use the app locale; add `?locale=ar` to switch it per request.

## Configuration

```bash
php artisan vendor:publish --tag="filament-cms-api-config"
```

```php
return [
    'active' => true,              // register the routes
    'prefix' => 'api/cms',
    'middleware' => ['api'],       // add 'auth:sanctum' to make the API private
    'per_page' => 15,
    'max_per_page' => 100,
    'models' => [
        'post' => \TomatoPHP\FilamentCms\Models\Post::class,
        'category' => \TomatoPHP\FilamentCms\Models\Category::class,
    ],
    'resources' => [
        'post' => \TomatoPHP\FilamentCmsApi\Transformers\PostResource::class,
        'category' => \TomatoPHP\FilamentCmsApi\Transformers\CategoryResource::class,
    ],
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
