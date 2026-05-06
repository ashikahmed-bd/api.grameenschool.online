<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory, WithHashId;

    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        return money($this->price, config('money.defaults.currency'), true)->format();
    }

    protected static function booted()
    {
        // // Before save → sync course price
        // static::saving(function ($item) {
        //     if (! $item->course) {
        //         return;
        //     }
        //     $item->price = $item->course->price ?? $item->course->base_price;
        // });

        // // After save → recalc cart
        // static::saved(function ($item) {
        //     $item->cart->sync();
        // });

        // // After delete → recalc cart
        // static::deleted(function ($item) {
        //     $item->cart->sync();
        // });
    }
}
