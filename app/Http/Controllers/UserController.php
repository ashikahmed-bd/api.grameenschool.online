<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query();

        if ($request->filled('role')) {
            $users->where('role', $request->input('role'));
        }

        if ($request->filled('query')) {
            $search = $request->input('query');

            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $results = $users->orderBy('created_at', 'asc')->paginate($request->get('limit', 10));

        return UserResource::collection($results);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'active' => $request->active,
        ]);

        if ($request->hasFile('avatar')) {
            $user->setAvatar($request->file('avatar'));
        }

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['instructor', 'student', 'referral', 'commissions']);
        return UserResource::make($user);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'active' => $request->active,
        ]);

        // Update avatar if exists
        if ($request->hasFile('avatar')) {
            $user->setAvatar($request->file('avatar'));
        }

        // Null safe instructor/student update
        if ($user->role === 'instructor' && $request->filled('instructor')) {
            $user->instructor()->update($request->input('instructor'));
        }

        if ($user->role === 'student' && $request->filled('student')) {
            $user->student()->update($request->input('student'));
        }

        return response()->json([
            'success' => true,
            'message' => 'User Updated Successfully',
        ], Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->deleteAvatar();

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }


    /**
     * Search the specified resource list.
     */
    public function search(Request $request)
    {
        $users = User::query()
            ->when($request->filled('role'), function ($q) use ($request) {
                $q->where('role', $request->role);
            })
            ->when($request->filled('query'), function ($q) use ($request) {
                $search = $request->get('query');

                $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return UserResource::collection($users);
    }
}
