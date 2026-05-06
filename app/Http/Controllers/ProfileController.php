<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\MeetResource;
use App\Http\Resources\MyCourseResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\Meet;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $user = $request->user();

        $profile = $user->student;

        if (!$profile) {
            return response()->json([
                'message' => 'Student profile not found.'
            ], 404);
        }

        $courses = Course::query()
            ->with([
                'author',
                'grade',
                'batch',
            ])
            ->withCount([
                'reviews',
                'lectures',
            ])
            ->withAvg('reviews', 'rating')
            ->where('active', true)
            ->where(function ($query) use ($profile) {

                // Grade Match
                $query->where('grade_id', $profile->grade_id);

                // If batch exists
                if ($profile->batch_id) {
                    $query->where(function ($q) use ($profile) {
                        $q->whereNull('batch_id')
                            ->orWhere('batch_id', $profile->batch_id);
                    });
                }
            })
            ->latest()
            ->get();

        return UserResource::make($user);
    }





    public function academic(AcademicRequest $request)
    {
        $user = $request->user();

        $student = $user->student()->updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'grade_id' => $request->grade_id,
                'batch_id' => $request->batch_id,
                'group_id' => $request->group_id,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'address' => $request->address,
                'school' => $request->school,
                'session' => $request->session,
                'is_active' => $request->is_active ?? true,
            ]
        );

        return response()->json([
            'message' => 'ক্লাস সফলভাবে পরিবর্তন করা হয়েছে',
            'user' => $student->fresh()
        ]);
    }


    public function courses(Request $request)
    {
        $user = $request->user();

        $query = $user->enrollments()
            ->withPivot(['progress', 'status', 'enrolled_at', 'completed_at']);

        $total = (clone $query)->count();

        $ongoing = (clone $query)->wherePivot('status', 'ongoing')->count();
        $completed = (clone $query)->wherePivot('status', 'completed')->count();

        $courses = $query
            ->with(['author', 'introduction'])
            ->withCount('lectures')
            ->latest('enrollments.enrolled_at')
            ->get();

        return response()->json([
            'total' => $total,
            'ongoing' => $ongoing,
            'completed' => $completed,
            'courses' => MyCourseResource::collection($courses),
        ]);
    }


    public function getMeets(Request $request)
    {
        $user = $request->user();

        $enrolled = $user->enrollments()
            ->pluck('course_id')
            ->toArray();

        $meets = Meet::with('course')
            ->where(function ($query) use ($enrolled) {
                $query->whereNull('course_id')
                    ->orWhereIn('course_id', $enrolled);
            })
            ->orderBy('time', 'asc')
            ->get();

        return MeetResource::collection($meets);
    }


    public function getOrders(Request $request)
    {
        $orders = Order::query()
            ->with(['user'])
            ->where('user_id', $request->user()->id)
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderByDesc('created_at')
            ->paginate(5);

        return OrderResource::collection($orders);
    }



    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name'   => ['sometimes', 'string', 'max:255'],
            'phone'  => ['sometimes', 'string', 'regex:/^[0-9]{11}$/', Rule::unique('users', 'phone')->ignore($user->id),],
            'email'  => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'avatar' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);


        // handle avatar upload (optional)
        if ($request->hasFile('avatar')) {
            // delete old avatar if you store the path
            if (Storage::disk($user->disk)->exists($user->avatar)) {
                Storage::disk($user->disk)->delete($user->avatar);
            }
            $pathUrl = $request->file('avatar')->store('avatars', config('app.disk'));
            Image::read($request->file('avatar'))->resize(80, 80)->save(Storage::disk(config('app.disk'))->path($pathUrl));
            $user->avatar = $pathUrl;
        }

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
        ], Response::HTTP_OK);
    }


    /**
     * Change password for the logged‑in user.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // (optional) revoke all other tokens except the current one
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ], Response::HTTP_OK);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ], Response::HTTP_OK);
    }
}
