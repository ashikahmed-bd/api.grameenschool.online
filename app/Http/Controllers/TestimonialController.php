<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\TestimonialResource;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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


    public function getTestimonials()
    {

        $testimonials = Cache::remember('homepage_testimonials', 3600, function () {
            return  Testimonial::query()->where('active', true)->get();
        });

        return response()->json([
            'title' => setting('testimonials.title') ?? '',
            'overview' => setting('testimonials.overview') ?? '',
            'items' => TestimonialResource::collection($testimonials),
        ]);
    }
}
