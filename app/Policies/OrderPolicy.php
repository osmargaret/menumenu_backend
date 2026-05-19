<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    public function view(?User $user, Order $order): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return (bool) $user;
    }

    public function update(User $user, Order $order): bool
    {
        // allow admin or kitchen owner to update status
        if ($user->isAdmin()) {
            return true;
        }

        return $order->kitchen && $order->kitchen->user_id === $user->id;
    }

    public function delete(User $user, Order $order): bool
    {
        return $user->isAdmin() || $user->id === $order->user_id;
    }
}
