<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DefaultRoleSeeder::class);
        $this->call(DefaultPermissionSeeder::class);
        $this->call(DefaultUserSeeder::class);
        $this->call(DefaultCountriesSeeder::class);
        $this->call(InvoiceSettingTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(SettingTableSeederFields::class);
        $this->call(DefaultCurrencySeeder::class);
        $this->call(SettingFavIconFieldSeeder::class);
        $this->call(PaymentFieldSeeder::class);
    }
}
