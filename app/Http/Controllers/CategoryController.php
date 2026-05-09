<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Enums\UserRole;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CourseResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CategoryResource;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['children'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->paginate();

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->parent_id = $request->parent_id;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        $category->sort_order = Category::where('parent_id', $request->parent_id)->max('sort_order') + 1;
        $category->show_on_homepage = $request->show_on_homepage ?? false;
        $category->overview = $request->overview;

        if ($request->hasFile('icon')) {
            $pathUrl = $request->file('icon')->store('categories', config('app.disk'));
            Image::read($request->file('icon'))->resize(250, 250)->save(Storage::disk(config('app.disk'))->path($pathUrl));
            $category->icon = $pathUrl;
        }

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return CategoryResource::make($category->load('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->parent_id = $request->parent_id;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;

        if ($request->filled('sort_order')) {
            $category->sort_order = $request->sort_order;
        }

        $category->show_on_homepage = $request->show_on_homepage ?? false;
        $category->overview = $request->overview;

        if ($request->hasFile('icon')) {
            if (Storage::disk($category->disk)->exists($category->icon)) {
                Storage::disk($category->disk)->delete($category->icon);
            }

            $pathUrl = $request->file('icon')->store('categories', config('app.disk'));
            Image::read($request->file('icon'))->resize(250, 250)->save(Storage::disk(config('app.disk'))->path($pathUrl));
            $category->icon = $pathUrl;
        }

        $category->update();

        return response()->json([
            'success' => true,
            'message' => 'Category Updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        if (! $request->user()->tokenCan((UserRole::ADMIN)->value)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update payment gateway settings.',
            ], Response::HTTP_FORBIDDEN);
        }

        if (Storage::disk($category->disk)->exists($category->icon)) {
            Storage::disk($category->disk)->delete($category->icon);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ], Response::HTTP_OK);
    }


    public function search()
    {
        $categories = Category::with(['children'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return CategoryResource::collection($categories);
    }



    public function getTopCategories()
    {
        $categories = Cache::remember('homepage_categories', 3600, function () {
            return Category::query()
                ->whereNull('parent_id')
                ->where('active', true)
                ->where('show_on_homepage', true)
                ->orderBy('sort_order')
                ->get();
        });

        return response()->json([
            'title' => setting('topCategories.title') ?? '',
            'overview' => setting('topCategories.overview') ?? '',
            'items' => CategoryResource::collection($categories),
        ]);
    }

    public function getCategories()
    {
        $categories = Cache::remember('navigation', 3600, function () {
            return Category::query()
                ->whereNull('parent_id')
                ->where('active', true)
                ->orderBy('sort_order')
                ->with(['children' => function ($query) {
                    $query->where('active', true)
                        ->orderBy('sort_order');
                }])
                ->get();
        });

        return CategoryResource::collection($categories);
    }


    public function getCourses(Category $category)
    {
        $categoryIds = collect([$category->id]);

        if (is_null($category->parent_id)) {
            $categoryIds = $categoryIds->merge(
                $category->children()->pluck('id')
            );
        }

        $courses = Course::query()
            ->with(['author'])
            ->withCount(['reviews', 'lectures'])
            ->withAvg('reviews', 'rating')
            ->where(function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds)
                    ->orWhereIn('subcategory_id', $categoryIds);
            })
            ->latest()
            ->paginate(12);

        return CourseResource::collection($courses)->additional([
            'category' => CategoryResource::make($category)
        ]);
    }
}
