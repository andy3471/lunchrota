<?php

use Illuminate\Database\Seeder;

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
