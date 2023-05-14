<?php

namespace App\Policies;

use App\Models\Hall;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HallPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_hall');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hall $hall): bool
    {
        return $user->can('view_hall');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_hall');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hall $hall): bool
    {
        return $user->can('update_hall');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hall $hall): bool
    {
        return $user->can('delete_hall');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Hall $hall): bool
    {
        return $user->can('restore_hall');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Hall $hall): bool
    {
        return $user->can('force_delete_hall');
    }
}
