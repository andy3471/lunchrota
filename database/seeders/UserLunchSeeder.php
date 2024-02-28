<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserLunchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Artisan::call('demo:seedlunch');
    }
}
