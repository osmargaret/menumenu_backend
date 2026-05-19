<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Kitchen;

class KitchenPolicy
{
    public function view(?User $user, Kitchen $kitchen): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return (bool) $user;
    }

    public function update(User $user, Kitchen $kitchen): bool
    {
        return $user->isAdmin() || $user->id === $kitchen->user_id;
    }

    public function delete(User $user, Kitchen $kitchen): bool
    {
        return $user->isAdmin() || $user->id === $kitchen->user_id;
    }
}
