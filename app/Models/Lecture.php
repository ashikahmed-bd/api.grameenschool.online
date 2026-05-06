<?php

namespace App\Models;

use App\Enums\LectureType;
use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lecture extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];


    protected $casts = [
        'type' => LectureType::class,
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function video()
    {
        return $this->hasOne(Video::class);
    }


    public function scopeHasContent(Builder $builder)
    {
        return $builder->where(function ($q) {
            $q->where('type', (LectureType::TEXT)->value)
                ->whereNotNull('body');
        })->orWhere(function ($q) {
            $q->where('type', (LectureType::VIDEO)->value)
                ->whereHas('video');
        });
    }


    public function hasContent()
    {
        if ($this->type == LectureType::TEXT && ! empty($this->body)) {
            return true;
        }
        if ($this->type == LectureType::VIDEO && ! empty($this->video)) {
            return true;
        }

        return false;
    }

    public function getNext()
    {
        return static::where('course_id', $this->course_id)
            ->where('sort_order', '>', $this->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first(['hashid', 'title']);
    }

    public function getPrevious()
    {
        return static::where('course_id', $this->course_id)
            ->where('sort_order', '<', $this->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first(['hashid', 'title']);
    }

    public function getDurationHMSAttribute()
    {
        if ($this->duration) {
            return convert_minutes_to_duration($this->duration);
        }

        return '00:00:00';
    }

    protected static function calculateArticleReadingTime($text)
    {
        $word_count = str_word_count(strip_tags($text));

        return round($word_count / 200, 2);
    }


    public function homework()
    {
        return $this->hasMany(Homework::class);
    }

    public function submissions()
    {
        return $this->hasManyThrough(
            Submission::class,  // Final model
            Homework::class,    // Intermediate model
            'lecture_id',       // Foreign key on Homework table
            'homework_id',      // Foreign key on Submission table
            'id',               // Local key on Lecture table
            'id'                // Local key on Homework table
        );
    }
}
