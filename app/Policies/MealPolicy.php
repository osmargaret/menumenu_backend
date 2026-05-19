<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Meal;
use App\Models\Kitchen;

class MealPolicy
{
    public function view(?User $user, Meal $meal): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return (bool) $user;
    }

    public function update(User $user, Meal $meal): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $meal->kitchen && $meal->kitchen->user_id === $user->id;
    }

    public function delete(User $user, Meal $meal): bool
    {
        return $this->update($user, $meal);
    }
}
