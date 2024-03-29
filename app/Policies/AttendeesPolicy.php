<?php

namespace App\Policies;

use App\Models\User;

class AttendeesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_attendees');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attendees $attendees): bool
    {
        return $user->can('view_attendees');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_attendees');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attendees $attendees): bool
    {
        return $user->can('update_attendees');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendees $attendees): bool
    {
        return $user->can('delete_attendees');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attendees $attendees): bool
    {
        return $user->can('restore_attendees');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attendees $attendees): bool
    {
        return $user->can('force_delete_attendees');
    }
}
