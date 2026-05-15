<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->where('active', true)
            ->orderBy('sort_order')
            ->with('children');
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
