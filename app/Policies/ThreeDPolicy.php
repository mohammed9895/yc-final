<?php

namespace App\Policies;

use App\Models\ThreeD;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ThreeDPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_three::d');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ThreeD $threeD): bool
    {
        return $user->can('view_three::d');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_three::d');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ThreeD $threeD): bool
    {
        return $user->can('update_three::d');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ThreeD $threeD): bool
    {
        return $user->can('delete_three::d');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ThreeD $threeD): bool
    {
        return $user->can('restore_three::d');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ThreeD $threeD): bool
    {
        return $user->can('force_delete_any_three::d');
    }
}
