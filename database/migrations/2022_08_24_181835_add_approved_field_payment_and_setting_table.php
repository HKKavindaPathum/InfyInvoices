<?php

use App\Models\Payment;
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
        Setting::create([
            'key' => 'payment_auto_approved',
            'value' => '1',
        ]);

        Schema::table('payments', function (Blueprint $table) {
            $table->integer('is_approved')->default(Payment::APPROVED)->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
