<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'id'            => $this->hashid,
            'title'         => $this->title,
            'subtitle'      => $this->subtitle,
            'image_url'     => $this->image_url,
            'link'       => $this->link,
            'text'       => $this->text,
            'sort_order'    => $this->sort_order,
            'target'    => $this->target,
            'active'        => (bool) $this->active,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
