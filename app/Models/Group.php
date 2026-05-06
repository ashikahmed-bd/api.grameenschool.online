<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
