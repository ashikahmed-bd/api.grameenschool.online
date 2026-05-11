<?php

namespace App\Models;

use App\Enums\EnrollmentStatus;
use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'completed_at' => 'datetime',
        'progress' => 'integer',
        'status' => EnrollmentStatus::class,

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
