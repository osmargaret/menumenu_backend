<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Define Roles
        $rolesData = [
            'super_admin' => 'Super Administrator',
            'manager' => 'Platform Manager',
            'finance' => 'Finance Officer',
            'support' => 'Support Specialist',
            'moderator' => 'Content Moderator',
        ];

        $roles = [];
        foreach ($rolesData as $name => $label) {
            $roles[$name] = Role::updateOrCreate(['name' => $name], ['label' => $label]);
        }

        // 2. Define Permissions
        $permissionsData = [
            'system_setting' => 'System Settings Access',
            'update_users' => 'Update User Profiles',
            'view_users' => 'View User List',
            'view_transactions' => 'View Financial Transactions',
            'manage_payouts' => 'Process Kitchen Payouts',
            'manage_refunds' => 'Process Order Refunds',
            'verify_kitchens' => 'Verify & Approve Kitchens',
            'manage_kitchens' => 'Manage Kitchen Profiles',
            'moderate_reviews' => 'Moderate Customer Reviews',
            'manage_blog' => 'Manage Blog & CMS Content',
            'view_live_map' => 'View Live Order Logistics Map',
            'manage_support' => 'Handle Support Tickets',
            'view_analytics' => 'View Platform Analytics',
            'manage_orders' => 'Manage & Update Orders',
            'manage_categories' => 'Manage Food Categories',
        ];

        $permissions = [];
        foreach ($permissionsData as $name => $label) {
            $permissions[$name] = Permission::updateOrCreate(['name' => $name], ['label' => $label]);
        }

        // 3. Assign Permissions to Roles
        
        // Super Admin gets everything
        $roles['super_admin']->permissions()->sync(Permission::all());

        // Manager
        $roles['manager']->permissions()->sync(Permission::whereIn('name', [
            'view_users', 'update_users', 'manage_kitchens', 'manage_orders', 
            'manage_categories', 'view_analytics', 'view_live_map', 'manage_blog'
        ])->get());

        // Finance
        $roles['finance']->permissions()->sync(Permission::whereIn('name', [
            'view_transactions', 'manage_payouts', 'manage_refunds', 'view_analytics'
        ])->get());

        // Support
        $roles['support']->permissions()->sync(Permission::whereIn('name', [
            'manage_support', 'view_users', 'view_orders', 'manage_orders'
        ])->get());

        // Moderator
        $roles['moderator']->permissions()->sync(Permission::whereIn('name', [
            'moderate_reviews', 'manage_blog', 'verify_kitchens', 'view_users'
        ])->get());

        // 4. Create Admin Users
        $stateId = DB::table('states')->first()->id ?? 1;
        $password = Hash::make('12345678');

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@menumenu.com',
                'role' => 'super_admin'
            ],
            [
                'name' => 'John Manager',
                'email' => 'manager@menumenu.com',
                'role' => 'manager'
            ],
            [
                'name' => 'Sarah Finance',
                'email' => 'finance@menumenu.com',
                'role' => 'finance'
            ],
            [
                'name' => 'Mike Support',
                'email' => 'support@menumenu.com',
                'role' => 'support'
            ],
            [
                'name' => 'Emma Moderator',
                'email' => 'moderator@menumenu.com',
                'role' => 'moderator'
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $password,
                    'state_id' => $stateId,
                ]
            );

            $user->roles()->sync([$roles[$userData['role']]->id]);
        }

        // 5. Create Dedicated Admin records (for the new Admin model)
        \App\Models\Admin::updateOrCreate(
            ['email' => 'superadmin@menumenu.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
