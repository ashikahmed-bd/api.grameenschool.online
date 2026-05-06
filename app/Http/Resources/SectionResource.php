<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'course' => $this->whenLoaded('course', fn() => [
                'id'   => $this->course->hashid,
                'title' => $this->course->title,
            ]),
            'can_trash' => ! $this->lectures->count(),
            'title' => $this->title,
            'icon_url' => $this->icon_url,
            'sort_order' => $this->sort_order,
            'lectures_count' => $this->whenCounted('lectures'),
            'lectures' => LectureResource::collection($this->whenLoaded('lectures')),
        ];
    }
}
