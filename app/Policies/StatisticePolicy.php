<?php

namespace App\Policies;

use App\Models\Statistice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StatisticePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_statistice');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Statistice $statistice): bool
    {
        return $user->can('view_statistice');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_statistice');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Statistice $statistice): bool
    {
        return $user->can('update_statistice');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Statistice $statistice): bool
    {
        return $user->can('delete_statistice');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Statistice $statistice): bool
    {
        return $user->can('restore_statistice');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Statistice $statistice): bool
    {
        return $user->can('force_delete_statistice');
    }
}
