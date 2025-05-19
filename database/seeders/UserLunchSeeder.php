<?php

declare(strict_types=1);

namespace Database\Seeders;

use Artisan;
use Illuminate\Database\Seeder;

class UserLunchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('demo:seedlunch');
    }
}
