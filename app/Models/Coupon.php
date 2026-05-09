<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => strtoupper($value),
        );
    }

    public function started(): bool
    {
        return is_null($this->starts_at) || $this->starts_at->isPast();
    }

    public function expired(): bool
    {
        return !is_null($this->expires_at) && $this->expires_at->isPast();
    }

    public function usageLimitReached(): bool
    {
        return !is_null($this->usage_limit)
            && $this->used_count >= $this->usage_limit;
    }

    public function isValid(): bool
    {
        return $this->active
            && $this->started()
            && ! $this->expired()
            && ! $this->usageLimitReached();
    }

    public function remainingUses(): ?int
    {
        if (is_null($this->usage_limit)) {
            return null;
        }

        return max(0, $this->usage_limit - $this->used_count);
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'percent') {
            return ($amount * $this->discount) / 100;
        }

        return min($this->discount, $amount);
    }
}
