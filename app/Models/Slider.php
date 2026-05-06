<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'active' => 'bool',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return Storage::disk($this->disk)->url('sliders/default.png');
        }

        return Storage::disk($this->disk)->url($this->image);
    }
}
