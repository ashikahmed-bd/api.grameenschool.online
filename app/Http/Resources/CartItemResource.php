<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'cart_id' => $this->cart->hashid,
            'course' => $this->when($this->course, fn() => ([
                'id' => $this->course->hashid,
                'title' => $this->course?->title,
                'cover_url' => $this->course->cover_url,
            ])),
            'quantity' => (int) $this->quantity,
            'price' => $this->price,
            'price_formatted' => money($this->price, config('money.defaults.currency'), true)->format(),
        ];
    }
}
