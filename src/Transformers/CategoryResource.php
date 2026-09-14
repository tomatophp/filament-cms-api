<?php

namespace TomatoPHP\FilamentCmsApi\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'for' => $this->for,
            'type' => $this->type,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'color' => $this->color,
            'show_in_menu' => (bool) $this->show_in_menu,
            'feature_image' => $this->getFirstMediaUrl('feature_image') ?: null,
            'cover_image' => $this->getFirstMediaUrl('cover_image') ?: null,
            'children' => static::collection($this->whenLoaded('children')),
        ];
    }
}
