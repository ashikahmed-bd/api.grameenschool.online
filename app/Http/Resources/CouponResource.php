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
        // return parent::toArray($request);

        return [
            'id'           => $this->hashid,
            'course' => $this->whenLoaded('course', fn() => $this->course ? [
                'id'         => $this->course->hashid,
                'title'      => $this->course->title,
                'slug'       => $this->course->slug,
                'price'      => $this->course->price,
                'price_formatted'      => $this->course->price_formatted,
                'base_price'      => $this->course->base_price,
                'base_price_formatted'      => $this->course->base_price_formatted,
                'cover_url'  => $this->course->cover_url,
            ] : null),
            'owner' => $this->whenLoaded('owner', fn() => $this->owner ? [
                'id'         => $this->owner->hashid,
                'name'       => $this->owner->name,
                'phone'      => $this->owner->phone,
                'email'      => $this->owner->email,
                'avatar_url' => $this->owner->avatar_url,
            ] : null),

            'code'         => $this->code,
            'discount'     => (float) $this->discount,
            'commission'   => (float) $this->commission,

            'type'         => $this->type,

            'usage' => [
                'limit'      => (int) $this->usage_limit,
                'used'       => (int) $this->used_count,
                'remaining'  => max(0, (int) $this->usage_limit - (int) $this->used_count),
            ],

            'is_active'    => (bool) $this->active,

            'starts_at'    => optional($this->starts_at)?->toISOString(),
            'expires_at'   => optional($this->expires_at)?->toISOString(),

            'created_at'   => optional($this->created_at)?->toISOString(),
            'updated_at'   => optional($this->updated_at)?->toISOString(),
        ];
    }
}
