<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseInstructor extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];
}
