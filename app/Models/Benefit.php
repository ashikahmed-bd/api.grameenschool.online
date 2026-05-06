<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Benefit extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    public function getBannerUrlAttribute()
    {
        if (! $this->banner) {
            return Storage::disk($this->disk)->url('default.png');
        }

        return Storage::disk($this->disk)->url($this->banner);
    }

    public function getVideoUrlAttribute(): string
    {
        return match ($this->provider) {
            'youtube' => "https://www.youtube.com/embed/{$this->video_id}",
            'vimeo' => "https://player.vimeo.com/video/{$this->video_id}",
            's3' => Storage::disk('s3')->url($this->video_id),
            'self' => asset("storage/videos/{$this->video_id}"),
            default => '',
        };
    }


    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (is_null($model->sort_order)) {
                $model->sort_order = self::max('sort_order') + 1;
            }
        });
    }
}
