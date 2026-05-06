<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
                'id' => $this->user->hashid,
                'name' => $this->user->name,
                'phone' => $this->user->phone,
                'avatar_url' => $this->user->avatar_url,
            ]),
            'invoice_id' => $this->invoice_id,

            'subtotal' => (float)$this->subtotal,
            'subtotal_formatted' => $this->subtotal_formatted,
            'discount' => (float)$this->discount,
            'discount_formatted' => $this->discount_formatted,
            'total' => (float) $this->total,
            'total_formatted' => $this->total_formatted,
            'paid_amount' => (float) $this->paid_amount,
            'paid_amount_formatted' => money($this->paid_amount, config('money.defaults.currency'), true)->format(),
            'due_amount' => (float) $this->due_amount,
            'due_amount_formatted' => money($this->due_amount, config('money.defaults.currency'), true)->format(),

            'payment_method' => $this->payment_method,
            'status' => $this->status,

            'paid_at' => $this->paid_at,
            'created_at' => $this->created_at,

            'items_count' => $this->whenLoaded('items', fn() => $this->items->count()),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
