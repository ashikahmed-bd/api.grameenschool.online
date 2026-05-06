<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'subcategory_id');
    }


    public function getIconUrlAttribute(): string
    {
        if (! $this->icon) {
            return Storage::disk(config('app.disk'))->url('categories/default.png');
        }

        return Storage::disk($this->disk)->url($this->icon);
    }
}
