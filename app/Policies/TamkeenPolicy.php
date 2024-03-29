<?php

namespace App\Policies;

use App\Models\Tamkeen;
use App\Models\User;

class TamkeenPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_tamkeen');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tamkeen $tamkeen): bool
    {
        return $user->can('view_tamkeen');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_tamkeen');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tamkeen $tamkeen): bool
    {
        return $user->can('update_tamkeen');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tamkeen $tamkeen): bool
    {
        return $user->can('delete_tamkeen');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tamkeen $tamkeen): bool
    {
        return $user->can('restore_tamkeen');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tamkeen $tamkeen): bool
    {
        return $user->can('force_delete_tamkeen');
    }
}
