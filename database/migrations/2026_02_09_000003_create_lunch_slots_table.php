<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lunch_slots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('team_id')->constrained()->cascadeOnDelete();
            $table->time('time');
            $table->integer('available')->default(3);
            $table->timestamps();
        });

        Schema::create('lunch_slot_user', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('lunch_slot_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->timestamps();

            $table->index(['lunch_slot_id', 'date']);
            $table->index(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lunch_slot_user');
        Schema::dropIfExists('lunch_slots');
    }
};
