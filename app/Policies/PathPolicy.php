<?php

namespace App\Policies;

use App\Models\Path;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PathPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_path');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Path $path): bool
    {
        return $user->can('view_path');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('view_path');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Path $path): bool
    {
        return $user->can('update_path');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Path $path): bool
    {
        return $user->can('delete_path');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Path $path): bool
    {
        return $user->can('restore_path');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Path $path): bool
    {
        return $user->can('force_delete_path');
    }
}
