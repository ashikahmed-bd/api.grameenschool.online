<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
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
            'homework' => HomeworkResource::make($this->whenLoaded('homework')),
            'user' => $this->whenLoaded('user', fn() =>  [
                'id' => $this->user->hashid,
                'name' => $this->user->name,
            ]),
            'answer' => $this->answer,
            'file_url' => $this->file_url,
            'marks' => $this->marks,
            'feedback' => $this->feedback,
            'graded_at' => $this->graded_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
