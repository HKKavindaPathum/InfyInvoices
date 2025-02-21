<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('value')->nullable()->change();
        });

        Setting::create([
            'key' => 'invoice_no_prefix',
            'value' => null,
        ]);
        Setting::create([
            'key' => 'invoice_no_suffix',
            'value' => null,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('value')->nullable(false)->change();
        });
        Setting::where('key', 'invoice_no_prefix')->delete();
        Setting::where('key', 'invoice_no_suffix')->delete();
    }
};
