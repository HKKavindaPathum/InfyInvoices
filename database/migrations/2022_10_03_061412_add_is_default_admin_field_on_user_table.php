<?php

use App\Models\Role;
use App\Models\User;
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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_default_admin')->default(false)->after('status');
        });

        $user = User::whereHas('roles', function ($query) {
            $query->where('name', Role::ROLE_ADMIN);
        })->orderBy('created_at', 'ASC')->first();
        if ($user) {
            $user->update(['is_default_admin' => 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_default_admin');
        });
    }
};
