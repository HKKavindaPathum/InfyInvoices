<?php

namespace Database\Seeders;

use App\Models\Role as CustomRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@infy-invoices.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
            'is_default_admin' => 1,
        ];
        $user = User::create($input);
        $user->assignRole(CustomRole::ROLE_ADMIN);
    }
}
