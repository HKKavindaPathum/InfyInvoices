<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role as CustomRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DefaultRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => CustomRole::ROLE_ADMIN,
                'display_name' => 'Admin',
                'is_default' => true,
            ],
            [
                'name' => CustomRole::ROLE_CLIENT,
                'display_name' => 'Client',
                'is_default' => true,
            ],
        ];

        foreach ($roles as $role) {
            $role = Role::create($role);
        }

        /** @var Role $adminRole */
        $adminRole = Role::whereName(CustomRole::ROLE_ADMIN)->first();

        /** @var User $user */
        $user = User::whereEmail('admin@project.com')->first();

        $allPermission = Permission::pluck('name', 'id');
        $adminRole->givePermissionTo($allPermission);
        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
