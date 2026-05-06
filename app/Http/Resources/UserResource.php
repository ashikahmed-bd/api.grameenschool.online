<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'                  => $this->hashid,
            'name'                => ucfirst($this->name),
            'email'               => $this->email,
            'email_verified_at'   => $this->email_verified_at,
            'phone'               => $this->phone,
            'avatar_url'          => $this->avatar_url,
            'active'              => (bool) $this->active,
            'role'                => $this->role,
            'balance'             => $this->balance,
            'balance_formatted'   => $this->balance_formatted,

            'institution'   => $this->institution,
            'specialization'   => $this->specialization,
            'bio'   => $this->bio,
            'grade'   => $this->grade,
            'group'   => $this->group,
            'session'   => $this->session,
            'preferred_language'   => $this->preferred_language,

            'created_at' => [
                'human' => $this->created_at->diffForHumans(),
                'timestamp' => $this->created_at,
            ],
            'updated_at' => [
                'human' => $this->updated_at->diffForHumans(),
                'timestamp' => $this->updated_at,
            ],
        ];
    }
}
