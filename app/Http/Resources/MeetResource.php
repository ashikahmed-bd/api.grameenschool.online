<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetResource extends JsonResource
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
            'course' => $this->whenLoaded('course', function () {
                return [
                    'id' => optional($this->course)->hashid,
                    'title' => optional($this->course)->title,
                ];
            }),
            'host' => $this->whenLoaded('host', [
                'id' => $this->host->hashid,
                'name' => $this->host->name,
                'avatar_url' => $this->host->avatar_url,
            ]),
            'provider' => $this->provider,
            'topic' => $this->topic,
            'meeting_id' => $this->meeting_id,
            'join_url' => $this->join_url,
            'host_url' => $this->host_url,
            'date' => $this->date,
            'date_formatted' => Carbon::parse($this->date)->format('d M Y'),
            'time' => $this->time,
            'time_formatted' => Carbon::parse($this->time)->format('h:i A'),
            'timezone' => $this->timezone,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
