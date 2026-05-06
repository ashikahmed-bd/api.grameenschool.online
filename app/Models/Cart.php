<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->items()->sum('price');
    }

    public function getDiscountAttribute(): float
    {
        $subtotal = (float) $this->items()->sum('price');
        $discount = 0;

        if ($this->coupon && $this->coupon->active) {

            if ($this->coupon->type === 'percent') {
                $discount = ($subtotal * $this->coupon->discount) / 100;
            } else {
                $discount = (float) $this->coupon->discount;
            }
        }
        return $discount;
    }

    public function getTotalAttribute(): float
    {
        return max(0, $this->subtotal - $this->discount);
    }
}
