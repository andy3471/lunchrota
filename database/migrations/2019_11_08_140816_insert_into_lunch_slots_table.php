<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

class InsertIntoLunchSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('lunch_slots')->insert([
            ['time' => '12:30'],
            ['time' => '13:30'],
            ['time' => '14:30'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('lunch_slots')->truncate();
    }
}
