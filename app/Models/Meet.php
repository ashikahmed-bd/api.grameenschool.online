<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meet extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_time' => 'string',
        'duration'   => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function scopeAccessibleByUser($query, $user)
    {
        return $query->whereNull('course_id')
            ->orWhereIn('course_id', $user->enrolledCourses->pluck('id'));
    }
}
