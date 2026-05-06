<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->hashid,
            'title' => $this->title,
            'slug' => $this->slug,
            'badge' => $this->badge,
            'description' => $this->description,
            'icon_url' => $this->icon_url,
            'banner_url' => $this->banner_url,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'canonical_url' => $this->canonical_url,
            'active' => (bool) $this->active,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'products' => CourseResource::collection($this->whenLoaded('courses')),
        ];
    }
}
