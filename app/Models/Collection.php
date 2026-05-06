<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];


    public function getBannerUrlAttribute(): string
    {
        return Storage::disk($this->disk)
            ->url($this->banner);
    }

    public function getIconUrlAttribute(): string
    {
        return Storage::disk($this->disk)
            ->url($this->icon);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
