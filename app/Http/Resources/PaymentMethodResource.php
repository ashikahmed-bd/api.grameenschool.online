<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            'key' => $this->key,
            'name' => $this->name,
            'enabled' => $this->enabled,
            'logo_url' => $this->logo_url,
            'credentials' => $this->credentials,
            'sandbox' => $this->sandbox,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
