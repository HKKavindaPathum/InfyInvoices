<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class InvoiceSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create(['key' => 'default_invoice_template', 'value' => 'defaultTemplate']);
        Setting::create(['key' => 'default_invoice_color', 'value' => '#040404']);
    }
}
