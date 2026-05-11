<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'state_id' => \App\Models\State::first()?->id ?? 1,
            ]
        );

        // ensure admin role exists and attach
        $role = Role::updateOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $admin->roles()->syncWithoutDetaching([$role->id]);

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'state_id' => \App\Models\State::first()?->id ?? 1,
            ]
        );

        // For the factory-generated users, we might want to check count or just skip if they exist
        if (User::count() < 12) {
            User::factory(10)->create();
        }
    }
}
