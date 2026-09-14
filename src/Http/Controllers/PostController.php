<?php

namespace TomatoPHP\FilamentCmsApi\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->applyLocale($request);

        $query = $this->published()->with(['categories', 'tags', 'media']);

        if ($request->filled('type')) {
            $query->where('type', $request->string('type')->toString());
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', fn (Builder $category) => $category->where('slug', $request->string('category')->toString()));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn (Builder $tag) => $tag->where('slug', $request->string('tag')->toString()));
        }

        if ($request->boolean('trend')) {
            $query->where('is_trend', true);
        }

        if ($request->filled('search')) {
            $search = '%' . $request->string('search')->toString() . '%';

            $query->where(fn (Builder $post) => $post->where('title', 'like', $search)->orWhere('slug', 'like', $search));
        }

        $posts = $query
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate($this->perPage($request))
            ->withQueryString();

        return $this->resource()::collection($posts);
    }

    public function show(Request $request, string $slug): JsonResource
    {
        $this->applyLocale($request);

        $post = $this->published()
            ->with(['categories', 'tags', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $resource = $this->resource();

        return new $resource($post);
    }

    /**
     * Only published posts whose publish date has passed are public.
     */
    protected function published(): Builder
    {
        $model = config('filament-cms-api.models.post');

        return $model::query()
            ->where('is_published', true)
            ->where(fn (Builder $query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    /**
     * @return class-string<JsonResource>
     */
    protected function resource(): string
    {
        return config('filament-cms-api.resources.post');
    }
}
