<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homework extends Model
{

    use HasFactory, WithHashId;

    protected $guarded = [];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
