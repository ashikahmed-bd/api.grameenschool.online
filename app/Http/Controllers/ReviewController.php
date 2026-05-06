<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reviews = Review::query()->with(['user', 'course'])->orderBy('created_at')->paginate($request->limit);
        return ReviewResource::collection($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'rating'      => 'required|integer|min:1|max:5',
            'comment'     => 'nullable|string',
        ]);

        $student = $request->user()->student;

        // check if review already exists
        $existing = $course->reviews()->where('user_id', $request->user()->id)->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this course.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $course->reviews()->create([
            'user_id'     => $request->user()->id,
            'name'        => $request->user()->name,
            'university'  => optional($student)->university,
            'department'  => optional($student)->department,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
