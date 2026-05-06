<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional helper to get lecture directly
    public function lecture()
    {
        return $this->homework->lecture();
    }

    public function getFileUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->file_path);
    }
}
