<?php

namespace App\Policies;

use App\Models\TalentRequest;
use App\Models\User;

class TalentRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_talent::request');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TalentRequest $talentRequest): bool
    {
        return $user->can('view_talent::request');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_talent::request');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TalentRequest $talentRequest): bool
    {
        return $user->can('update_talent::request');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TalentRequest $talentRequest): bool
    {
        return $user->can('delete_talent::request');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TalentRequest $talentRequest): bool
    {
        return $user->can('restore_talent::request');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TalentRequest $talentRequest): bool
    {

    }
}
