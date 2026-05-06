<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'public' => 'boolean',
    ];
}
