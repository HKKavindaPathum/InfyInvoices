<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class PaymentFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create(['key' => 'stripe_key', 'value' => '']);
        Setting::create(['key' => 'stripe_secret', 'value' => '']);
        Setting::create(['key' => 'paypal_client_id', 'value' => '']);
        Setting::create(['key' => 'paypal_secret', 'value' => '']);
        Setting::create(['key' => 'razorpay_key', 'value' => '']);
        Setting::create(['key' => 'razorpay_secret', 'value' => '']);
        Setting::create(['key' => 'stripe_enabled', 'value' => 0]);
        Setting::create(['key' => 'paypal_enabled', 'value' => 0]);
        Setting::create(['key' => 'razorpay_enabled', 'value' => 0]);
    }
}
