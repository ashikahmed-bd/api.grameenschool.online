<?php

namespace App\Http\Controllers;

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Enums\EnrollmentStatus;
use App\Enums\Provider;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LectureResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserResource;
use App\Models\Batch;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::query();

        $paginated = $courses->withCount('students', 'reviews', 'lectures')
            ->orderByDesc('created_at')
            ->paginate();


        return CourseResource::collection($paginated)->additional([
            'total_draft'     => $courses->where('status', CourseStatus::DRAFT->value)->count(),
            'total_pending' => $courses->where('status', CourseStatus::PENDING->value)->count(),
            'total_published' => $courses->where('status', CourseStatus::PUBLISHED->value)->count(),
            'total_archived'  => $courses->where('status', CourseStatus::ARCHIVED->value)->count(),
        ]);
    }


    public function store(CourseRequest $request)
    {
        $course = new Course();

        $course->user_id = $request->user()->id;
        $course->category_id = Category::getId($request->category_id);
        $course->subcategory_id = Category::getId($request->subcategory_id);
        $course->collection_id = Collection::getId($request->collection_id);
        $course->grade_id = Grade::getId($request->grade_id);
        $course->batch_id = Batch::getId($request->batch_id);

        $course->title = $request->title;
        $course->slug = Str::slug($request->title);
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
        $course->slug = Str::slug($request->title);
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

        $extension = $file->getClientOriginalExtension();
        $fileName = Str::slug($course->slug) . '.' . $extension;

        $path = $file->storeAs('covers', $fileName, config('app.disk'));

        Image::read($request->file('cover'))
            ->cover(600, 360)
            ->save(Storage::disk(config('app.disk'))->path($path));

        $course->update([
            'cover' => $path,
            'disk' => config('app.disk'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course Cover Updated'
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

        return CourseResource::make($course);
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


    public function getFeaturedCourses()
    {
        $courses = Course::published()->where('is_feature', true)
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'title' => 'পছন্দের কোর্স করুন, নিজেকে সেরা করে গড়ে তুলুন',
            'subtitle' => 'আমাদের কোর্সগুলো আপনাকে নতুন দক্ষতা অর্জন করতে ও পেশাগত জীবনে এগিয়ে যেতে সাহায্য করবে, নিজের
                        গতিতে শিখুন এবং হয়ে উঠুন আরও আত্মবিশ্বাসী।',
            'items' => CourseResource::collection($courses),
        ]);
    }

    public function getLatestCourses()
    {
        $courses = Course::published()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->take(9)
            ->get();

        return response()->json([
            'title' => 'আমাদের সর্বশেষ কোর্সসমূহ',
            'subtitle' => 'সময়ের সাথে তাল মিলিয়ে তৈরি করা আপডেটেড ও চাহিদাসম্পন্ন নতুন কোর্সসমূহ একসাথে,
                        যেখানে বাস্তব অভিজ্ঞতা ও স্কিল ডেভেলপমেন্টকে দেওয়া হয়েছে সর্বোচ্চ গুরুত্ব।',
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
