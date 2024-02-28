<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserLunchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \Artisan::call('demo:seedlunch');
    }
}
