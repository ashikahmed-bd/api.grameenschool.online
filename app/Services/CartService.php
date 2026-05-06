<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function __construct(private ?Cart $cart = null)
    {
        $this->current();
    }

    /** Get current cart */
    public function getCurrent(): ?Cart
    {
        return $this->cart;
    }

    /** Load or create current cart */
    public function current(): void
    {
        $user = Auth::user();

        if ($user) {
            $this->cart = Cart::where('user_id', $user->id)
                ->firstOrCreate([
                    'user_id' => $user->id,
                ]);
        } else {
            $token = $this->getCurrentCartToken();
            $this->cart = Cart::where('token', $token)
                ->firstOrCreate([
                    'token' => $token,
                ]);
        }
    }

    /** Check if cart has course */
    public function hasCourse(Course $course): bool
    {
        return $this->cart->items()
            ->where('course_id', $course->id)
            ->exists();
    }

    /** Add course to cart */
    public function add(Course $course): void
    {
        if (! $this->hasCourse($course)) {
            $this->cart->items()->create([
                'course_id' => $course->id,
                'price'     => $course->price ?? $course->base_price,
                'quantity'  => 1,
            ]);
        }
    }

    /** Remove course from cart */
    public function remove(Course $course): void
    {
        $this->cart->items()
            ->where(['course_id' => $course->id])
            ->delete();
    }

    /** Check if cart empty */
    public function isEmpty(): bool
    {
        return ! $this->cart->items()->exists();
    }

    /** Apply coupon code to cart items */
    public function applyCoupon(string $code): void
    {
        if ($this->isEmpty()) {
            abort(422, "Your cart is empty. Add items before applying a coupon.");
        }

        $coupon = Coupon::where('code', strtoupper($code))->first();

        if (! $coupon) {
            abort(422, "Coupon code '{$code}' does not exist.");
        }

        if (! $coupon->isValid()) {
            abort(422, "Coupon code '{$coupon->code}' is expired, inactive, or not usable.");
        }

        DB::transaction(function () use ($coupon) {

            $items = $this->cart->items->filter(function ($item) use ($coupon) {
                return !$coupon->course_id || $coupon->course_id == $item->course_id;
            });

            if ($items->isEmpty()) {
                abort(422, "Coupon does not apply to any items in your cart.");
            }

            // $totalDiscount = 0;

            // $items->each(function ($item) use ($coupon, &$totalDiscount) {

            //     if ($coupon->type === 'percent') {
            //         $discount = ($item->price * $coupon->discount) / 100;
            //     } else {
            //         $discount = $coupon->discount;
            //     }

            //     $totalDiscount += $discount;
            // });

            $this->cart->update([
                'coupon_id' => $coupon->id,
            ]);

            // usage tracking
            $coupon->increment('used_count');

            if (!is_null($coupon->usage_limit)) {
                $remaining = $coupon->usage_limit - $coupon->used_count;

                if ($remaining <= 0) {
                    $coupon->update(['active' => false]);
                }
            }
        });
    }


    /** Clear cart */
    public function clear(): void
    {
        $this->cart->items()->delete();
    }

    /** Generate or get cart token for guest users */
    protected function getCurrentCartToken(): string
    {
        $token = request()->header('X-CART-TOKEN');

        if (! $token) {
            $token = (string) Str::ulid();
            request()->headers->set('X-CART-TOKEN', $token);
        }

        return $token;
    }
}
