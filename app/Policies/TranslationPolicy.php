<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use io3x1\FilamentTranslations\Models\Translation;

class TranslationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_translation');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Translation $translation): bool
    {
        return $user->can('view_translation');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_translation');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Translation $translation): bool
    {
        return $user->can('update_translation');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Translation $translation): bool
    {
        return $user->can('delete_translation');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Translation $translation): bool
    {
        return $user->can('restore_translation');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Translation $translation): bool
    {
        return $user->can('view_translation');
    }
}
