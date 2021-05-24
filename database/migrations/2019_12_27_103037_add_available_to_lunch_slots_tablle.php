<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailableToLunchSlotsTablle extends Migration
{
    public function up()
    {
        Schema::table('lunch_slots', function (Blueprint $table) {
            $table->integer('available')->default('3');
        });
    }

    public function down()
    {
        Schema::table('lunch_slots', function (Blueprint $table) {
            $table->dropColumn('available');
        });
    }
}
