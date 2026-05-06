<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BenefitResource extends JsonResource
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
            'description' => $this->description,
            'banner_url' => $this->banner_url,
            'provider' => $this->provider,
            'video_id' => $this->video_id,
            'video_url' => $this->video_url,
            'sort_order' => $this->sort_order,
        ];
    }
}
