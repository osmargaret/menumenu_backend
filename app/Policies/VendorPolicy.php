<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;

class VendorPolicy
{
    public function view(?User $user, Vendor $vendor): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return (bool) $user;
    }

    public function update(User $user, Vendor $vendor): bool
    {
        return $user->isAdmin() || $user->id === $vendor->user_id;
    }

    public function delete(User $user, Vendor $vendor): bool
    {
        return $user->isAdmin() || $user->id === $vendor->user_id;
    }
}
