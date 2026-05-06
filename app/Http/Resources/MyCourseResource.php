<?php

namespace App\Http\Resources;

use App\Models\CourseProgress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //  return parent::toArray($request);

        return [
            'id'         => $this->hashid,
            'title'      => $this->title,
            'slug'       => $this->slug,
            'cover_url'      => $this->cover_url,

            'author' => $this->whenLoaded('author', fn() => [
                'id' => $this->author->hashid,
                'name' => $this->author->name,
                'avatar_url' => $this->author->avatar_url,
            ]),
            'lectures_count' => $this->whenCounted('lectures_count'),
            'enrollment' => [
                'status' => $this->pivot->status ?? null,
                'progress' => (int) ($this->pivot->progress ?? 0),
                'enrolled_at' => $this->pivot->enrolled_at ?? null,
                'completed_at' => $this->pivot->completed_at ?? null,
            ],
            'intro' => $this->whenLoaded('introduction', fn() => $this->introduction ? [
                'id' => $this->introduction->hashid,
                'title' => $this->introduction->title,
            ] : null),

            'start_url' => $this->introduction
                ? "/dashboard/courses/{$this->slug}/lectures/{$this->introduction->hashid}"
                : "/dashboard/courses/{$this->slug}",
        ];
    }
}
