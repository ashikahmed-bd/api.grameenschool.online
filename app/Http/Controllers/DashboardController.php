<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Course;
use App\Enums\UserRole;
use App\Models\Enrollment;
use App\Enums\CourseStatus;
use App\Http\Resources\OrderResource;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {

        $courses = Course::query();
        $users = User::query();
        $enrollments = Enrollment::query();

        $orders = Order::with(['user'])->latest()->take(5)->get();
        $users = User::query()
            ->where('role', UserRole::STUDENT)
            ->latest()
            ->take(5)
            ->get();

        $courses = Course::withCount('students', 'reviews')
            ->orderBy('students_count', 'desc')
            ->take(5)
            ->get();

        return response()->json([

            'stats' => [
                'total_courses' => $courses->count(),
                'total_draft' => (clone $courses)->where('status', CourseStatus::DRAFT->value)->count(),
                'total_pending' => (clone $courses)->where('status', CourseStatus::PENDING->value)->count(),
                'total_published' => (clone $courses)->where('status', CourseStatus::PUBLISHED->value)->count(),
                'total_archived' => (clone $courses)->where('status', CourseStatus::ARCHIVED->value)->count(),
                'total_students' => (clone $users)->where('role', UserRole::STUDENT)->count(),
                'total_instructors' => (clone $users)->where('role', UserRole::INSTRUCTOR)->count(),
                'total_enrolled' => $enrollments->count(),
            ],

            'recent_orders' => OrderResource::collection($orders),

            'top_courses' => $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'code' => $course->code,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'cover_url' => $course->cover_url,
                    'base_price' => round($course->base_price),
                    'base_price_formatted' => $course->base_price_formatted,
                    'price' => round($course->price),
                    'price_formatted' => $course->price_formatted,
                    'enrollments_count' => $course->enrollments_count,
                    'average_rating' => round($course->average_rating, 1),
                    'reviews_count' => $course->reviews_count,
                ];
            }),

            'latest_users' => $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar_url' => $user->avatar_url,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'balance_formatted' => $user->balance_formatted,
                    'created_at' => [
                        'human' => $user->created_at->diffForHumans(),
                        'timestamp' => $user->created_at,
                    ],
                ];
            }),

            'system_logs' => PersonalAccessToken::with('tokenable')
                ->orderBy('last_used_at', 'desc')
                ->take(20)
                ->get()
                ->map(function ($token) {
                    return [
                        'user_id' => $token->tokenable_id,
                        'name' => optional($token->tokenable)->name,
                        'phone' => optional($token->tokenable)->phone,
                        'role' => optional($token->tokenable)->role,
                        'token_name' => $token->name,
                        'ip' => $token->ip ?? 'N/A',
                        'user_agent' => getBrowserName($token->user_agent),
                        'last_used_at' => $token->last_used_at?->diffForHumans() ?? 'Never',
                        'created_at' => $token->created_at,
                    ];
                }),


            'graphs' => [
                'daily_income_chart' => [
                    ['date' => '2025-07-24', 'amount' => 3000],
                    ['date' => '2025-07-25', 'amount' => 6200],
                    ['date' => '2025-07-26', 'amount' => 4500],
                    ['date' => '2025-07-27', 'amount' => 7000],
                    ['date' => '2025-07-28', 'amount' => 5800],
                    ['date' => '2025-07-29', 'amount' => 8200],
                ],
                'new_users_chart' => [
                    ['date' => '2025-07-24', 'count' => 15],
                    ['date' => '2025-07-25', 'count' => 18],
                    ['date' => '2025-07-26', 'count' => 21],
                    ['date' => '2025-07-27', 'count' => 10],
                    ['date' => '2025-07-28', 'count' => 25],
                    ['date' => '2025-07-29', 'count' => 17],
                ],
            ],


        ], Response::HTTP_OK);
    }
}
