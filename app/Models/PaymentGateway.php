<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentGateway extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'credentials' => 'array',
        'enabled' => 'boolean',
        'sandbox' => 'boolean',
    ];

    protected $hidden = [
        'credentials',
    ];

    public function getLogoUrlAttribute()
    {
        if (! $this->logo) {
            return Storage::disk($this->disk)->url('default.png');
        }

        return Storage::disk($this->disk)->url($this->logo);
    }
}
