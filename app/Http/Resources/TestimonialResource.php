<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
            'name' => $this->name,
            'tagline' => $this->tagline,
            'photo_url' => $this->photo_url,
            'cover_url' => $this->cover_url,
            'video_id' => $this->video_id,
            'provider' => $this->provider,
            'active' => (bool) $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
