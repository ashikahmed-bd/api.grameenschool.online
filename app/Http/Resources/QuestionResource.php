<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'user' => $this->whenLoaded('user', fn() => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar_url' => $this->user->avatar_url,
            ]),
            'lecture' => LectureResource::make($this->whenLoaded('lecture')),
            'title' => $this->title,
            'body' => $this->body,
            'answered' => !is_null($this->body),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
