<?php

namespace App\Models;

use App\Enums\VideoStatus;
use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'status' => VideoStatus::class,
        'uploaded_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function lecture(): BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }

    public function getVideoUrlAttribute(): string
    {
        return match ($this->provider) {
            'youtube' => "https://www.youtube.com/embed/{$this->video_id}",
            'vimeo' => "https://player.vimeo.com/video/{$this->video_id}",
            'self' => asset("storage/videos/{$this->video_id}"),
            default => '',
        };
    }
}
