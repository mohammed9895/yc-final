<?php

namespace App\Policies;

use App\Models\Tender;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TenderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_tinder');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tender $tender): bool
    {
        return $user->can('view_tinder');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_tinder');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tender $tender): bool
    {
        return $user->can('update_tinder');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tender $tender): bool
    {
        return $user->can('delete_tinder');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tender $tender): bool
    {
        return $user->can('restore_tinder');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tender $tender): bool
    {
        return $user->can('force_delete_tinder');
    }
}
