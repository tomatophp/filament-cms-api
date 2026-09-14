<?php

namespace TomatoPHP\FilamentCmsApi\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'keywords' => $this->keywords,
            'body' => $this->body,
            'is_trend' => (bool) $this->is_trend,
            'likes' => $this->likes,
            'views' => $this->views,
            'meta_url' => $this->meta_url,
            'feature_image' => $this->getFirstMediaUrl('feature_image') ?: null,
            'cover_image' => $this->getFirstMediaUrl('cover_image') ?: null,
            'images' => $this->getMedia('images')->map->getUrl()->values(),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'tags' => CategoryResource::collection($this->whenLoaded('tags')),
            'published_at' => $this->published_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
