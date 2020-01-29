<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
use App\LunchSlot;

class UserLunchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Artisan::call('demo:seedlunch');
    }
}
