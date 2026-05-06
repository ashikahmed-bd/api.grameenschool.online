<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Support\Str;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'status' => PaymentStatus::class,
        'amount' => 'float',
        'paid_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountFormattedAttribute(): string
    {
        return money($this->amount, config('money.defaults.currency'), true)->format();
    }

    public function getDiscountFormattedAttribute(): string
    {
        return money($this->discount, config('money.defaults.currency'), true)->format();
    }

    public function getTotalFormattedAttribute(): string
    {
        return money($this->total, config('money.defaults.currency'), true)->format();
    }
}
