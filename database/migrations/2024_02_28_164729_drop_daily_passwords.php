<?php

declare(strict_types=1);

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
        Schema::dropIfExists('daily_passwords');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('daily_passwords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('password');
            $table->string('password2');
        });
    }
};
