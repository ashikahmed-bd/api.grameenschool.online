<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coupons = Coupon::query()
            ->with(['owner'])
            ->orderBy('created_at', 'asc')
            ->paginate($request->limit);
        return CouponResource::collection($coupons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        Coupon::create([
            'course_id'   => Course::getId($request->course_id) ?? null,
            'owner_id'    => Course::getId($request->owner_id) ?? null,
            'code'        => strtoupper($request->code),
            'type'        => $request->type,
            'discount'    => $request->discount,
            'commission'  => $request->commission ?? 0,
            'usage_limit' => $request->usage_limit,
            'used_count'  => 0,
            'starts_at'   => $request->starts_at ?? null,
            'expires_at'  => $request->expires_at ?? null,
            'active'      => $request->active ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
