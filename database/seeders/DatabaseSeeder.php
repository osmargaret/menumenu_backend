<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountriesSeeder::class,
            NigeriaStatesCitiesSeeder::class,
            AdminRoleSeeder::class,
            UsersTableSeeder::class,
            KitchensTableSeeder::class,
            MealsTableSeeder::class,
            BlogSeeder::class,
            OrdersTableSeeder::class,
            KitchenVerificationsSeeder::class,
            RefundsSeeder::class,
            PayoutsSeeder::class,
        ]);
    }
}
