<?php

namespace App\Policies;

use App\Models\Freelancers;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FreelancersPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_freelancers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Freelancers $freelancers): bool
    {
        return $user->can('view_freelancers');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_freelancers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Freelancers $freelancers): bool
    {
        return $user->can('update_freelancers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Freelancers $freelancers): bool
    {
        return $user->can('delete_freelancers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Freelancers $freelancers): bool
    {
        return $user->can('restore_freelancers');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Freelancers $freelancers): bool
    {
        return $user->can('force_delete_freelancers');
    }
}
