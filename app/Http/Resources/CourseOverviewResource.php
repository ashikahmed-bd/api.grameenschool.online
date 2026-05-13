<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseOverviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->hashid,

            'author' => $this->whenLoaded('author', function () {
                return $this->author ? [
                    'id' => $this->author->hashid,
                    'name' => $this->author->name,
                    'avatar_url' => $this->author->avatar_url,
                ] : null;
            }),
            $this->mergeWhen($this->whenLoaded('category'), [
                'category' => $this->category ? [
                    'id' => $this->category->hashid,
                    'name' => $this->category->name,
                    'slug' => $this->category->slug,
                ] : null,

                'subcategory' => $this->subcategory ? [
                    'id' => $this->subcategory->hashid,
                    'name' => $this->subcategory->name,
                    'slug' => $this->subcategory->slug,
                ] : null,
            ]),

            'collection' => $this->whenLoaded('collection', fn() => [
                'id'   => $this->collection->hashid,
                'title' => $this->collection->title,
                'slug' => $this->collection->slug,
            ]),

            'title' => $this->title,
            'slug' => $this->slug,
            'overview' => $this->overview,
            'description' => $this->description,

            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'canonical_url' => client_url($this->canonical_url) . '/' . $this->hashid,

            'base_price' => round($this->base_price),
            'base_price_formatted' => $this->base_price_formatted,
            'price' => round($this->price),
            'price_formatted' => $this->price_formatted,
            'access_days' => $this->access_days,

            'level' => $this->level,
            'learnings'    => $this->learnings ?? [],
            'requirements' => $this->requirements ?? [],
            'includes'     => $this->includes ?? [],

            'cover_url' => $this->cover_url,
            'intro_id' => $this->intro_id,

            'status' => $this->status,
            'created_at' => [
                'human' => $this->created_at->diffForHumans(),
                'timestamp' => $this->created_at->toISOString(),
                'formatted' => $this->created_at->format('Y-m-d H:i:s'),
                'date' => $this->created_at->format('d M Y'),
            ],

            'updated_at' => [
                'human' => $this->updated_at->diffForHumans(),
                'timestamp' => $this->updated_at->toISOString(),
                'formatted' => $this->updated_at->format('Y-m-d H:i:s'),
                'date' => $this->updated_at->format('d M Y'),
            ],
            'average_rating' => round($this->reviews_avg_rating, 1),
            'reviews_count'  => $this->whenCounted('reviews'),
            'lectures_count' => (int) $this->whenCounted('lectures'),
            'students_count' => (int) $this->whenCounted('students'),

            'sections' => SectionResource::collection($this->whenLoaded('sections')),
        ];
    }
}
