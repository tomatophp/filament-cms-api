![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-cms-api/master/art/screenshot.jpg)

# Filament cms api

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-cms-api/version.svg)](https://packagist.org/packages/tomatophp/filament-cms-api)
[![License](https://poser.pugx.org/tomatophp/filament-cms-api/license.svg)](https://packagist.org/packages/tomatophp/filament-cms-api)
[![Downloads](https://poser.pugx.org/tomatophp/filament-cms-api/d/total.svg)](https://packagist.org/packages/tomatophp/filament-cms-api)

API Support for Filament CMS Builder

## Installation

```bash
composer require tomatophp/filament-cms-api
```
after install your package please run this command

```bash
php artisan filament-cms-api:install
```

finally register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentCmsApi\FilamentCmsApiPlugin::make())
```


## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-cms-api-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-cms-api-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-cms-api-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-cms-api-migrations"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
