<?php

namespace App\Policies;

use App\Filament\Pages\TendersList;
use App\Models\Tender;
use App\Models\User;

class TendersListPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {

    }

    public function view(User $user, TendersList $tendersList): bool
    {
        return false;
    }
}
