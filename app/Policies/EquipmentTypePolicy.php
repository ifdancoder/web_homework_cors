<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EquipmentType;

class EquipmentTypePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, EquipmentType $equipmentType)
    {
        return $user->id === $equipmentType->user_id;
    }
}
