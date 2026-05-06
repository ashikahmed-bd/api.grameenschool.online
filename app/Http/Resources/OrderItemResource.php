<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'order' => OrderResource::make($this->whenLoaded('order')),
            'course' => $this->whenLoaded('course', fn() => [
                'id' => $this->course->id,
                'title' => $this->course->title,
                'cover_url' => $this->course->cover_url,
            ]),
            'price' => $this->price,
            'price_formatted' => $this->price_formatted,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),


        ];
    }
}
