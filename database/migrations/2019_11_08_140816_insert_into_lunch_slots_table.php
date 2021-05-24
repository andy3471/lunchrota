<?php

use Illuminate\Database\Migrations\Migration;

class InsertIntoLunchSlotsTable extends Migration
{
    public function up()
    {
        DB::table('lunch_slots')->insert([
            ['time' => '12:30'],
            ['time' => '13:30'],
            ['time' => '14:30'],
        ]);
    }

    public function down()
    {
        DB::table('lunch_slots')->truncate();
    }
}
