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
            'author' => $this->whenLoaded('author', fn() => [
                'id'   => $this->author->hashid,
                'name' => $this->author->name,
                'avatar_url' => $this->author->avatar_url,
                'institution' => $this->author->institution,
                'specialization' => $this->author->specialization,
                'bio' => $this->author->bio,
            ]),
            'title' => $this->title,
            'slug' => $this->slug,
            'overview' => $this->overview,
            'description' => $this->description,

            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'canonical_url' => $this->canonical_url,

            'base_price' => $this->base_price,
            'base_price_formatted' => $this->base_price_formatted,
            'price' => round($this->price),
            'price_formatted' => $this->price_formatted,
            'access_days' => $this->access_days,

            'level' => $this->level,
            'duration' => (int) $this->duration,
            'duration_formatted' => $this->duration_formatted,
            'is_feature' => (bool) $this->is_feature,

            'target' => $this->whenLoaded('target', fn() => [
                'learnings'    => $this->target->learnings ?? [],
                'requirements' => $this->target->requirements ?? [],
                'benefits'     => $this->target->benefits ?? [],
            ]),

            'cover_url' => $this->cover_url,
            'intro' => [
                'video_id' => $this->video_id,
                'provider' => $this->provider,
                'video_url' => $this->video_url,
            ],
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
            'reviews_count' => $this->whenCounted('reviews'),
            'lectures_count' => $this->whenCounted('lectures'),
            'enrollments_count' => $this->whenCounted('enrollments'),
        ];
    }
}
