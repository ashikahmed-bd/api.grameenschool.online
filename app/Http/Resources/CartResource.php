<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'coupon' => $this->whenLoaded('coupon', fn() => ([
                'id' => $this->coupon->hashid,
                'code' => $this->coupon->code,
                'discount' => $this->coupon->discount,
                'type' => $this->coupon->type,
            ])),

            'token' => $this->token,
            'subtotal' => $this->subtotal,
            'subtotal_formatted' => money($this->subtotal, config('money.defaults.currency'), true)->format(),
            'discount' => $this->discount,
            'discount_formatted' => money($this->discount, config('money.defaults.currency'), true)->format(),
            'total' => $this->total,
            'total_formatted' => money($this->total, config('money.defaults.currency'), true)->format(),
            'status' => $this->status,
            'items' => CartItemResource::collection($this->items),
        ];
    }
}
