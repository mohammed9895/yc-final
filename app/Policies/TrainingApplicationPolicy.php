<?php

namespace App\Policies;

use App\Models\TrainingApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TrainingApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_training::alppication');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TrainingApplication $trainingApplication): bool
    {
        return $user->can('view_training::alppication');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_training::alppication');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TrainingApplication $trainingApplication): bool
    {
        return $user->can('update_training::alppication');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TrainingApplication $trainingApplication): bool
    {
        return $user->can('delete_training::alppication');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TrainingApplication $trainingApplication): bool
    {
        return $user->can('restore_training::alppication');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TrainingApplication $trainingApplication): bool
    {
        //
    }
}
