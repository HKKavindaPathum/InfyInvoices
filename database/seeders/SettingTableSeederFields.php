<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeederFields extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'company_address',
            'value' => 'C-303, Atlanta Shopping Mall, Nr. Sudama Chowk, Mota Varachha, Surat - 394101, Gujarat, India.',
        ]);
        Setting::create(['key' => 'company_phone', 'value' => '+91 70963 36561']);
    }
}
