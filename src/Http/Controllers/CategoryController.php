<?php

namespace TomatoPHP\FilamentCmsApi\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->applyLocale($request);

        $query = $this->active()->with(['media']);

        if ($request->filled('for')) {
            $query->where('for', $request->string('for')->toString());
        }

        if ($request->filled('type')) {
            $query->where('type', $request->string('type')->toString());
        }

        if ($request->boolean('menu')) {
            $query->where('show_in_menu', true);
        }

        if ($request->boolean('root')) {
            $query->whereNull('parent_id');
        }

        $categories = $query
            ->orderBy('id')
            ->paginate($this->perPage($request))
            ->withQueryString();

        return $this->resource()::collection($categories);
    }

    public function show(Request $request, string $slug): JsonResource
    {
        $this->applyLocale($request);

        $category = $this->active()
            ->with(['media', 'children' => fn ($children) => $children->where('is_active', true)])
            ->where('slug', $slug)
            ->firstOrFail();

        $resource = $this->resource();

        return new $resource($category);
    }

    protected function active(): Builder
    {
        $model = config('filament-cms-api.models.category');

        return $model::query()->where('is_active', true);
    }

    /**
     * @return class-string<JsonResource>
     */
    protected function resource(): string
    {
        return config('filament-cms-api.resources.category');
    }
}
