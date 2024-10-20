<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Equipment;

class EquipmentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Equipment $equipment)
    {
        return $user->id === $equipment->user_id;
    }
}
