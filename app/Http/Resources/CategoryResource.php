<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //        return parent::toArray($request);
        return [
            'id'               => $this->hashid,
            'name'             => $this->name,
            'slug'             => $this->slug,
            'meta_title'       => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords'    => $this->meta_keywords,
            'parent_id'        => $this->parent_id,
            'sort_order'       => $this->sort_order,
            'show_on_homepage' => $this->show_on_homepage,
            'overview'         => $this->overview,
            'icon_url'         => $this->icon_url,
            'active'           => (bool) $this->active,
            'created_at' => [
                'human' => $this->created_at->diffForHumans(),
                'timestamp' => $this->created_at,
            ],
            'updated_at' => [
                'human' => $this->updated_at->diffForHumans(),
                'timestamp' => $this->updated_at,
            ],
            'deleted_at'       => $this->deleted_at,

            // Nested Children (Recursive Resource)
            'children' => CategoryResource::collection($this->whenLoaded('children')),
            // Courses
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
        ];
    }
}
