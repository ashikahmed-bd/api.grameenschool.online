<?php

namespace App\Models;

use App\Enums\CourseLevel;
use App\Traits\WithHashId;
use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'level' => CourseLevel::class,
        'price' => 'float',
        'learnings'    => 'array',
        'requirements' => 'array',
        'includes' => 'array',
        'status' => CourseStatus::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    public function instructors()
    {
        return $this->belongsToMany(
            User::class,
            'course_instructors', // Pivot table name
            'course_id', // Foreign key in pivot
            'user_id' // Related key in pivot
        );
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }

    public function introduction()
    {
        return $this->lectures()->one()->ofMany('sort_order', 'min');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
    }

    public function getBasePriceFormattedAttribute()
    {
        return money($this->base_price, config('money.defaults.currency'), true)->format();
    }


    public function getPriceFormattedAttribute()
    {
        return money($this->price, config('money.defaults.currency'), true)->format();
    }


    public function getCoverUrlAttribute()
    {
        if (! $this->cover) {
            return Storage::disk($this->disk)->url('courses/default.png');
        }

        return Storage::disk($this->disk)->url($this->cover);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function getAverageRatingAttribute(): string
    {
        $avg = $this->reviews()->where('approved', true)->avg('rating');
        return number_format($avg ?? 0, 1);
    }


    protected function getRatingBreakdown()
    {
        return collect([5, 4, 3, 2, 1])->mapWithKeys(function ($star) {
            return [$star => $this->reviews()->where('rating', $star)->where('approved', true)->count()];
        });
    }
}
