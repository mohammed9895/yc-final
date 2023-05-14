<?php

namespace App\Policies;

use App\Models\Evaluate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EvaluatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return  $user->can('view_any_evaluate');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Evaluate $evaluate): bool
    {
        return  $user->can('view_evaluate');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->can('create_evaluate');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Evaluate $evaluate): bool
    {
        return  $user->can('update_evaluate');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Evaluate $evaluate): bool
    {
        return  $user->can('delete_evaluate');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Evaluate $evaluate): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Evaluate $evaluate): bool
    {
        //
    }
}
