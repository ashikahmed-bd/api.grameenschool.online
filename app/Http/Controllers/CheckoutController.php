<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $cart = Cart::with('items.course')
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty. Please add at least one course before proceeding to checkout.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $order = Order::query()->create([
            'user_id' => $request->user()->id,
            'subtotal' => $cart->subtotal,
            'discount' => $cart->discount,
            'total' => $cart->total,
            'paid'    => 0,
            'due'     => $cart->total,
            'status' => OrderStatus::PENDING,
        ]);

        foreach ($cart->items as $item) {
            OrderItem::query()->create([
                'order_id' => $order->id,
                'course_id' => $item->course_id,
                'price' => $item->course->price ?? $item->course->base_price,
                'quantity' => $item->quantity,
                'total' => $item->course->price ?? $item->course->base_price * $item->quantity,
            ]);
        }

        // Clear cart
        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'order' => OrderResource::make($order),
        ], Response::HTTP_CREATED);
    }
}
