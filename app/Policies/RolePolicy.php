<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->role === 'admin'
            ? Response::allow()
            : Response::deny('You must be an administrator.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user)
    {
        return $user->role === 'admin'
            ? Response::allow()
            : Response::deny('You are not allowed to view this user.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->role === 'admin'
            ? Response::allow()
            : Response::deny('Only administrators can create users.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        return $user->role === 'admin'
            ? Response::allow()
            : Response::deny('You are not allowed to update this user.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->role === 'admin'
            ? Response::allow()
            : Response::deny('You are not allowed to delete this user.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user)
    {
        return $user->role === 'admin'
            ? Response::allow()
            : Response::deny('Only administrators can restore users.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user)
    {
        return $user->role === 'admin'
            ? Response::allow()
            : Response::deny('Only administrators can permanently delete users.');
    }
}
