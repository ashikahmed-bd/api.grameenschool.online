<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'user' => UserResource::make($this->whenLoaded('user')),
            'order' => OrderResource::make($this->whenLoaded('order')),
            'invoice_id' => $this->invoice_id,
            'transaction_id' => $this->transaction_id,
            'method' => $this->method,
            'amount' => $this->amount,
            'amount_formatted' => $this->amount_formatted,
            'status' => $this->status,
            'paid_at' => Carbon::parse($this->paid_at)->format('d F, Y h:i A'),
            'refunded_at' => $this->refunded_at,
            'meta' => $this->meta,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
