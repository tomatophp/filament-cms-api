# V5.0.0

- aligned with the TomatoPHP Filament v5 ecosystem: requires `tomatophp/filament-cms` ^5.0, Laravel 12/13, PHP 8.2+
- working read-only endpoints for posts and categories (`/api/cms/posts`, `/api/cms/categories`) with filters, pagination and `?locale=`
- only published posts and active categories are exposed
- configurable prefix, middleware, page size, models and resources
- breaking: removed the unused FAQ, ticket and page transformers and the `api/pages` routes, which pointed at a controller that never shipped
- test suite for every endpoint; Laravel 12/13 x PHP 8.3/8.4 test matrix

# V1.0.0

First release of the package
