<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->student_id)) {
                $year = date('Y');
                $lastId = self::whereYear('created_at', $year)->count() + 1;
                $model->student_id = $year . str_pad($lastId, 4, '0', STR_PAD_LEFT);
            }
        });

        static::saving(function ($model) {
            if (empty($model->student_id)) {
                $year = date('Y');
                $lastId = self::whereYear('created_at', $year)->count() + 1;
                $model->student_id = $year . str_pad($lastId, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
