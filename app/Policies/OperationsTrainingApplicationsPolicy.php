<?php

namespace App\Policies;

use App\Models\OperationsTrainingApplications;
use App\Models\User;

class OperationsTrainingApplicationsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_operations::training::application');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OperationsTrainingApplications $OperationsTrainingApplications): bool
    {
        return $user->can('view_operations::training::application');
    }

}
