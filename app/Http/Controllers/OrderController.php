<?php

namespace App\Http\Controllers;

use App\Enums\EnrollmentStatus;
use App\Enums\OrderStatus;
use App\Http\Resources\OrderResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $invoiceId = $request->query('invoice_id');

        $orders = Order::query()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($invoiceId, function ($query) use ($invoiceId) {
                $query->where('invoice_id', 'like', '%' . $invoiceId . '%');
            })
            ->orderByDesc('created_at')
            ->paginate($request->query('limit', 10));

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'user_id'   => 'required|exists:users,hashid',
            'course_id' => 'required|exists:courses,hashid',
            'quantity'  => 'nullable|integer|min:1',
            'discount'  => 'nullable|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request) {

            $user = User::where('hashid', $request->user_id)->firstOrFail();
            $course = Course::where('hashid', $request->course_id)->firstOrFail();

            $qty = $request->quantity ?? 1;
            $discount = $request->discount ?? 0;

            $subtotal = $course->price * $qty;
            $total = max($subtotal - $discount, 0);

            // prevent duplicate enrollment
            if (Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->exists()
            ) {
                abort(409, 'Looks like you\'re already enrolled in this course!');
            }

            $order = Order::create([
                'user_id'        => $user->id,
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'total'          => $total,
                'paid'    => 0,
                'due'     => $total,
                'payment_method' => 'manual',
                'status'         => OrderStatus::PENDING,
            ]);

            OrderItem::create([
                'order_id'  => $order->id,
                'course_id' => $course->id,
                'quantity'  => $qty,
                'price'     => $course->price,
            ]);

            Enrollment::create([
                'user_id'     => $user->id,
                'course_id'   => $course->id,
                'order_id'    => $order->id,
                'progress'    => 0,
                'status'      => EnrollmentStatus::ONGOING,
                'enrolled_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Enrollment successful. Your access has been activated.',
                'order'   => $order->load('items')
            ]);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['items.course', 'user', 'payment']);
        return OrderResource::make($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
