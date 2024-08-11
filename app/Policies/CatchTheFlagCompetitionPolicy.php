<?php

namespace App\Policies;

use App\Models\CatchTheFlagCompetition;
use App\Models\User;

class CatchTheFlagCompetitionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_catch::the::flag::competition');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CatchTheFlagCompetition $catchTheFlagCompetition): bool
    {
        return $user->can('view_catch::the::flag::competition');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_catch::the::flag::competition');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CatchTheFlagCompetition $catchTheFlagCompetition): bool
    {
        return $user->can('update_catch::the::flag::competition');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CatchTheFlagCompetition $catchTheFlagCompetition): bool
    {
        return $user->can('delete_catch::the::flag::competition');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CatchTheFlagCompetition $catchTheFlagCompetition): bool
    {
        return $user->can('restore_catch::the::flag::competition');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CatchTheFlagCompetition $catchTheFlagCompetition): bool
    {
        return $user->can('force_delete_catch::the::flag::competition');
    }
}
