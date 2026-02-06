<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Run the migrations. */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('app_del');
        });

        Schema::dropIfExists('app_del_support_days');
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('app_del')->default(false);
        });

        Schema::create('app_del_support_days', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('date');
            $table->timestamps();
        });
    }
};
