<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCurrent();

        return CartResource::make($cart->load('coupon', 'items.course'));
    }



    public function add(Course $course)
    {
        $this->cartService->add($course);

        return response()->json([
            'success' => true,
            'message' => 'Course added to cart',
        ]);
    }


    public function remove(Course $course)
    {
        $this->cartService->remove($course);

        return response()->json([
            'success' => true,
            'message' => 'Course removed from cart',
        ]);
    }


    public function clear()
    {
        $this->cartService->clear();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }

    public function hasCourse(Course $course)
    {
        return response()->json($this->cartService->hasCourse($course));
    }


    public function isEmpty()
    {
        $empty = $this->cartService->isEmpty();

        return response()->json([
            'success' => true,
            'isEmpty' => $empty,
        ]);
    }


    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $this->cartService->applyCoupon($request->input('code'));

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully',
        ]);
    }
}
