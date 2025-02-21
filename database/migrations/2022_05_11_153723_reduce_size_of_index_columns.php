<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('media', function ($table) {
            $table->string('model_type', 161)->change();
            $table->longText('manipulations')->change();
            $table->longText('custom_properties')->change();
            $table->longText('generated_conversions')->change();
            $table->longText('responsive_images')->change();
        });
        Schema::table('model_has_permissions', function ($table) {
            $table->string('model_type', 161)->change();
        });
        Schema::table('model_has_roles', function ($table) {
            $table->string('model_type', 161)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function ($table) {
            $table->string('model_type', 255)->change();
            $table->json('manipulations')->change();
            $table->json('custom_properties')->change();
            $table->json('generated_conversions')->change();
            $table->json('responsive_images')->change();
        });
        Schema::table('model_has_permissions', function ($table) {
            $table->string('model_type', 255)->change();
        });
        Schema::table('model_has_roles', function ($table) {
            $table->string('model_type', 255)->change();
        });
    }
};
