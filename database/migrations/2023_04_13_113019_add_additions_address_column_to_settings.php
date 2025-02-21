<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settings = [
            ['key' => 'city', 'value' => 'Surat'],
            ['key' => 'state', 'value' => 'Gujarat'],
            ['key' => 'country', 'value' => 'India'],
            ['key' => 'zipcode', 'value' => '394101'],
            ['key' => 'fax_no', 'value' => '555-123-4567'],
            ['key' => 'show_additional_address_in_invoice', 'value' => 0],
        ];
        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
