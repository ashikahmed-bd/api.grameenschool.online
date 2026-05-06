<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Rules\PhoneNumberRule;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use App\Notifications\ResetPasswordNotification;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $user = User::query()->create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => UserRole::STUDENT,
        ]);

        $token = $user->createToken('auth-token', [$user->role], now()->addWeek());

        $user->tokens()->update([
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Registered Successfully',
            'token' => $token->plainTextToken,
            'user' => [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'grade' => $user->grade,
                'group' => $user->group,
                'session' => $user->session,
                'avatar_url' => $user->avatar_url,
            ],
        ], Response::HTTP_CREATED);
    }


    public function login(LoginRequest $request)
    {
        if (!Auth::attempt([
            'phone'    => $request->phone,
            'password' => $request->password
        ])) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed. Please check your phone and password.',
            ], Response::HTTP_FORBIDDEN);
        }

        $user = Auth::user();

        if (!$user->active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been disabled. Please contact support.',
            ], Response::HTTP_FORBIDDEN);
        }

        // Remove old tokens before creating a new one
        // $user->tokens()->delete();

        $token = $user->createToken('auth-token', [$user->role], now()->addWeek());

        $user->tokens()->update([
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'You are login successfully!',
            'token' => $token->plainTextToken,
            'user' => [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url,
                'role' => $user->role,
            ],
        ], Response::HTTP_OK);
    }


    public function forgot(Request $request)
    {
        $request->validate([
            'phone' => ['required', new PhoneNumberRule()],
        ]);

        $user = User::query()->where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found with this phone number.',
            ], Response::HTTP_FOUND);
        }

        $tempPassword = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Update user's password
        $user->password = Hash::make($tempPassword);
        $user->save();

        // Notify user via SMS
        $user->notify(new ResetPasswordNotification($tempPassword));

        return response()->json([
            'success' => true,
            'message' => 'password has been sent to your phone number.',
        ]);
    }
}
