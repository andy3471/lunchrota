<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertIntoRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')->insert([
            ['name' => 'In Office', 'available' => '1'],
            ['name' => 'Annual Leave', 'available' => '0'],
            ['name' => 'Sick', 'available' => '0'],
            ['name' => 'Training', 'available' => '0'],
            ['name' => 'Authorised Absence', 'available' => '0'],
            ['name' => 'Coordinator', 'available' => '1'],
            ['name' => 'On-Call', 'available' => '1'],
            ['name' => 'Early', 'available' => '1'],
            ['name' => 'Early/On-Call', 'available' => '1'],
            ['name' => 'Training/On-Call', 'available' => '0'],
            ['name' => 'Early/Coordinator', 'available' => '1'],
            ['name' => 'Maternity/Paternity', 'available' => '0'],
            ['name' => 'Half-Day PM', 'available' => '0'],
            ['name' => 'Half-Day AM', 'available' => '0'],
            ['name' => 'Coordinator/On-Call', 'available' => '1'],
            ['name' => 'Early/Coordinator/On-Call', 'available' => '1'],
            ['name' => 'Backlog', 'available' => '1'],
            ['name' => 'Early/Backlog', 'available' => '1'],
            ['name' => 'On-Call/Backlog', 'available' => '1'],
            ['name' => 'Early/Backlog/On-Call', 'available' => '1'],
            ['name' => 'Workshop', 'available' => '1'],
            ['name' => 'WFH', 'available' => '0']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->truncate();
    }
}
