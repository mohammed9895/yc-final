<?php

namespace App\Policies;

use App\Models\GCCCamp;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GCCCampPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_g::c::c::camp');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GCCCamp $gCCCamp): bool
    {
        return $user->can('view_g::c::c::camp');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_g::c::c::camp');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GCCCamp $gCCCamp): bool
    {
        return $user->can('update_g::c::c::camp');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GCCCamp $gCCCamp): bool
    {
        return $user->can('delete_g::c::c::camp');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GCCCamp $gCCCamp): bool
    {
        return $user->can('restore_g::c::c::camp');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GCCCamp $gCCCamp): bool
    {
        return $user->can('force_delete_g::c::c::camp');
    }
}
