<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CollectionResource;
use Symfony\Component\HttpFoundation\Response;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collections = Collection::query()->orderBy('created_at', 'asc')->paginate();
        return CollectionResource::collection($collections);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|file|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'banner' => 'nullable|file|mimes:jpg,jpeg,png,svg,webp|max:4096',
            'status' => ['required', 'string', Rule::enum(BundleStatus::class)],
        ]);

        $bundle = Bundle::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description ?? null,
            'status' => $request->status ?? BundleStatus::PUBLISHED->value,
        ]);

        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store("bundles/icons", config('app.disk'));
            $bundle->update(['icon' => $iconPath]);
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store("bundles/banners", config('app.disk'));
            $bundle->update(['banner' => $bannerPath]);
        }

        return response()->json([
            'message' => 'Bundle created successfully',
            'bundle' => $bundle->load('courses')
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        return CollectionResource::make($collection);
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

    public function getCollections()
    {
        $collections = Collection::query()
            ->orderBy('sort_order', 'desc')->get();
        return CollectionResource::collection($collections);
    }

    public function getCollectionCourses(Collection $collection)
    {
        $courses = $collection->courses()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->with(['category'])
            ->paginate(12);

        return CourseResource::collection($courses)->additional([
            'collection' => new CollectionResource($collection),
        ]);
    }
}
