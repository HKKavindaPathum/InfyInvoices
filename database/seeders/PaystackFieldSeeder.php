<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class PaystackFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create(['key' => 'paystack_key', 'value' => '']);
        Setting::create(['key' => 'paystack_secret', 'value' => '']);
        Setting::create(['key' => 'paystack_enabled', 'value' => 0]);
    }
}
