<?php

namespace App\Http\Controllers;

use App\Enums\CourseLevel;
use App\Enums\EnrollmentStatus;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CourseOverviewResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LectureResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Format;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::query()
            ->with(['category:id,hashid,name,slug'])
            ->withCount('students', 'reviews', 'lectures')
            ->orderByDesc('created_at')
            ->paginate();

        return CourseResource::collection($courses);
    }


    public function store(CourseRequest $request)
    {
        $course = new Course();

        $course->user_id = $request->user()->id;
        $course->category_id = Category::getId($request->category_id);
        $course->subcategory_id = Category::getId($request->subcategory_id);
        $course->collection_id = Collection::getId($request->collection_id);

        $course->title = $request->title;
        $course->slug = Str::slug($request->slug);
        $course->overview = $request->overview;
        $course->description = $request->description;

        $course->meta_title = $request->meta_title;
        $course->meta_description = $request->meta_description;
        $course->meta_keywords = $request->meta_keywords;
        $course->canonical_url = $request->canonical_url;

        $course->base_price = $request->base_price;
        $course->price = $request->price;
        $course->access_days = $request->access_days;
        $course->level = $request->level ?? CourseLevel::ALL;
        $course->is_feature = $request->is_feature;
        $course->is_bundle = $request->is_bundle;

        $course->learnings = $request->learnings;
        $course->requirements = $request->requirements;
        $course->includes = $request->includes;

        $course->status = $request->status;
        $course->save();

        // new course created notification
        // User::query()->where('role', UserRole::STUDENT)
        //     ->chunk(100, function ($users) use ($course) {
        //         foreach ($users as $user) {
        //             $user->notify((new CreateCourseNotification($course))->delay([
        //                 'mail' => now()->addMinutes(5),
        //                 'sms' => now()->addMinutes(10),
        //             ]));
        //         }
        //     });

        return response()->json([
            'success' => true,
            'message' => 'Course Created Successfully!',
        ], Response::HTTP_CREATED);
    }


    public function show(Course $course)
    {
        return CourseResource::make($course->load(['category', 'subcategory', 'sections.lectures']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getBasic(Course $course)
    {
        $categories = Category::with(['children' => fn($query) => $query->orderBy('sort_order')])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return response()->json([
            'course' => CourseResource::make($course->load('category', 'collection')),
            'categories' => CategoryResource::collection($categories),
            'levels' => CourseLevel::getArray(),
        ], Response::HTTP_OK);
    }


    public function updateBasic(Request $request, Course $course)
    {
        $course->user_id = $request->user()->id;
        $course->category_id = Category::getId($request->category_id);
        $course->subcategory_id = Category::getId($request->subcategory_id);
        $course->collection_id = Collection::getId($request->collection_id);

        $course->title = $request->title;
        $course->slug = Str::slug($request->slug);
        $course->overview = $request->overview;
        $course->description = $request->description;
        $course->meta_title = $request->meta_title;
        $course->meta_description = $request->meta_description;
        $course->meta_keywords = $request->meta_keywords;
        $course->canonical_url = $request->canonical_url;
        $course->access_days = $request->access_days ?? null;
        $course->level = $request->level;
        $course->learnings = $request->learnings;
        $course->requirements = $request->requirements;
        $course->includes = $request->includes;

        $course->base_price = $request->base_price;
        $course->price = $request->price;
        $course->intro_id = $request->intro_id;
        $course->status = $request->status;

        $course->update();

        return response()->json([
            'success' => true,
            'message' => 'Course Updated Successfully',
        ], Response::HTTP_OK);
    }



    public function uploadCover(Request $request, Course $course)
    {
        $request->validate([
            'cover' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $file = $request->file('cover');

        if ($course->cover && Storage::disk($course->disk)->exists($course->cover)) {
            Storage::disk($course->disk)->delete($course->cover);
        }

        $path = $file->storeAs('covers', pathinfo($course->slug, PATHINFO_FILENAME) . '.webp', config('app.disk'));

        $encoded = Image::decode($file)
            ->cover(1200, 630)
            ->encodeUsingFormat(
                Format::WEBP,
                progressive: true,
                quality: 70
            );

        Storage::disk(config('app.disk'))->put($path, (string) $encoded);

        $course->update([
            'cover' => $path,
            'disk' => config('app.disk'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course Cover Updated',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        if (Storage::disk($course->disk)->exists("courses/{$course->code}")) {
            Storage::disk($course->disk)->deleteDirectory("courses/{$course->code}");
        }

        return response()->json([
            'success' => true,
            'message' => 'Course Deleted Success',
        ], Response::HTTP_OK);
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        $courses = Course::with(['author'])
            ->when($query, function ($course) use ($query) {
                $course->where(function ($search) use ($query) {
                    $search->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%");
                })
                    ->orWhereHas('author', function ($author) use ($query) {
                        $author->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->latest()
            ->get();

        return CourseResource::collection($courses);
    }



    public function courses(Request $request)
    {
        $courses = Course::published()->orderBy('created_at', 'desc')->paginate($request->limit);
        return CourseResource::collection($courses);
    }

    public function details(string $slug, Course $course)
    {
        $course->load(['author'])
            ->loadCount(['students', 'lectures']);

        return CourseOverviewResource::make($course);
    }

    public function instructors(Course $course)
    {
        $course->load(['instructors']);

        return UserResource::collection($course->instructors);
    }


    public function reviews(Request $request, Course $course)
    {
        $reviews = $course->reviews()
            ->with(['user'])
            ->orderByDesc('created_at')
            ->paginate($request->limit);

        return ReviewResource::collection($reviews)->additional([
            'average_rating' => round($course->reviews->avg('rating'), 1),
            'total_reviews' => $course->reviews()->count(),
            'rating_breakdown' => [
                5 => $course->reviews()->where('rating', 5)->count(),
                4 => $course->reviews()->where('rating', 4)->count(),
                3 => $course->reviews()->where('rating', 3)->count(),
                2 => $course->reviews()->where('rating', 2)->count(),
                1 => $course->reviews()->where('rating', 1)->count(),
            ],
        ]);
    }

    public function bundleCourses()
    {
        $courses = Cache::remember(
            'bundle_courses',
            3600,
            fn() => Course::published()
                ->with('category:id,hashid,name,slug')
                ->where('is_bundle', true)
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->latest()
                ->get()
        );

        return response()->json([
            'title' => 'এক কোর্সে নয়, সম্পূর্ণ স্কিল প্যাকেজ একসাথে',
            'subtitle' => 'ক্যারিয়ার, একাডেমিক ও স্কিল ডেভেলপমেন্টের জন্য বাছাইকৃত একাধিক প্রিমিয়াম কোর্স নিয়ে তৈরি বিশেষ বান্ডেল। কম খরচে বেশি শেখার সুযোগ নিয়ে নিজেকে এগিয়ে রাখুন।',
            'items' => CourseResource::collection($courses),
        ]);
    }


    public function featuredCourses()
    {

        $courses = Cache::remember(
            'featured_courses',
            3600,
            fn() => Course::published()
                ->with('category:id,name,slug')
                ->where('is_feature', true)
                ->where('is_bundle', false)
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->latest()
                ->get()
        );

        return response()->json([
            'title' => 'সবচেয়ে জনপ্রিয় ও স্টুডেন্টদের পছন্দের কোর্সসমূহ',
            'subtitle' => 'ইন্ডাস্ট্রি ডিমান্ড, স্টুডেন্ট সাকসেস ও আপডেটেড কারিকুলামের ভিত্তিতে নির্বাচিত আমাদের সেরা ফিচারড কোর্সগুলো দিয়ে আজই শুরু করুন আপনার শেখার যাত্রা।',
            'items' => CourseResource::collection($courses),
        ]);
    }



    public function coursesByAuthor(User $user)
    {
        $courses = $user->courses()
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate();

        return CourseResource::collection($courses);
    }


    public function curriculum(Course $course)
    {
        $course->refresh()->load([
            'sections' => function ($query) {
                $query->withCount('lectures');
            },
            'sections.lectures.video'
        ]);
        return SectionResource::collection($course->sections);
    }


    public function overview(string $slug, Course $course)
    {
        $course->load(['author'])->loadCount(['lectures', 'students']);
        return CourseResource::make($course);
    }


    public function learn(Course $course, Lecture $lecture)
    {
        $enrolled = Enrollment::query()
            ->where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($enrolled->status === EnrollmentStatus::LOCKED) {
            return response()->json([
                'success' => false,
                'message' => 'Your enrollment is locked. Please complete payment to access this course.',
            ], 403);
        }

        $course->load(['author', 'sections.lectures'])
            ->loadCount('lectures');

        return response()->json([
            'lecture' => LectureResource::make($lecture->load('video')),
            'previous' => $lecture->getPrevious(),
            'next' => $lecture->getNext(),
            'course' => CourseResource::make($course),
        ]);
    }
}
