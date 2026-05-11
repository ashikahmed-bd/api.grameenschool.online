<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    public function getPhotoUrlAttribute(): string
    {
        if (! $this->avatar) {
            return Storage::disk('public')->url('avatars/default.png');
        }

        return Storage::disk($this->disk)->url($this->photo);
    }

    public function getCoverUrlAttribute(): string
    {
        if (! $this->cover) {
            return Storage::disk('public')->url('testimonials/default.png');
        }

        return Storage::disk($this->disk)->url($this->cover);
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
