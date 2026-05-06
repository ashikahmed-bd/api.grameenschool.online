<?php

namespace App\Http\Resources;

use App\Enums\LectureType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this?->hashid,
            'title' => $this->title,
            'sort_order' => $this->sort_order,
            'course' => $this->course?->hashid,
            'section' => $this->section?->hashid,
            'type' => $this->type,
            'body' => $this->body,
            'duration' => [
                'hms' => $this->duration_hms,
            ],
            'has_content' => $this->hasContent(),
            'sort_order' => $this->sort_order,
            'video' => $this->when(
                $this->type === LectureType::VIDEO,
                fn() => $this->whenLoaded('video', fn() => [
                    'id' => $this->video?->hashid,
                    'title' => $this->video?->title,
                    'provider' => $this->video?->provider,
                    'video_id' => $this->video?->video_id,
                    'video_url' => $this->video?->video_url,
                ])
            ),

            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
        ];
    }
}
