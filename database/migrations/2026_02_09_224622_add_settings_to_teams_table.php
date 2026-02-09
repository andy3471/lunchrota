<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->boolean('register_enabled')->default(true);
            $table->boolean('reset_password_enabled')->default(false);
            $table->boolean('roles_enabled')->default(true);
            $table->boolean('lunch_slot_calculated')->default(false);
            $table->decimal('lunch_slot_calculated_ratio', 3, 2)->default(0.33);
            $table->string('default_role')->default('none');
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn([
                'register_enabled',
                'reset_password_enabled',
                'roles_enabled',
                'lunch_slot_calculated',
                'lunch_slot_calculated_ratio',
                'default_role',
            ]);
        });
    }
};
