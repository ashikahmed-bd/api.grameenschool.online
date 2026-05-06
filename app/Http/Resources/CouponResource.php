<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);

        return [
            'id' => $this->hashid,
            'code' => $this->code,
            'percent' => $this->percent,
            'quantity' => $this->quantity,
            'expired' => $this->expired(),
            'expires_at' => $this->expires_at?->format('d M, Y'),
            'active' => $this->active,
            'valid' => $this->isValid(),
            'link' => "?coupon={$this->code}",
        ];
    }
}
