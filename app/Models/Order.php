<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    protected $casts = [
        'status' => OrderStatus::class,
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    public function getSubtotalFormattedAttribute(): string
    {
        return money($this->subtotal, config('money.defaults.currency'), true)->format();
    }

    public function getDiscountFormattedAttribute(): string
    {
        return money($this->discount, config('money.defaults.currency'), true)->format();
    }


    public function getTotalFormattedAttribute(): string
    {
        return money($this->total, config('money.defaults.currency'), true)->format();
    }


    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->invoice_id)) {
                $model->invoice_id = 'INV-' . now()->format('ymdHis');
            }
        });
    }
}
