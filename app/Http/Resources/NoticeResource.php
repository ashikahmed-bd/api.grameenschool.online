<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
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
            'id' => $this->hashid,
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type,
            'target' => $this->target,
            'published' => (bool) $this->published,
            'creator' => $this->whenLoaded('creator', [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
                'title' => $this->creator->title,
                'avatar_url' => $this->creator->avatar_url,
            ]),

            'created_at' => [
                'human' => $this->created_at->diffForHumans(),
                'timestamp' => $this->created_at,
            ],
            'updated_at' => [
                'human' => $this->updated_at->diffForHumans(),
                'timestamp' => $this->updated_at,
            ],

        ];
    }
}
