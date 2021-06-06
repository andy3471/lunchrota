<?php

namespace Database\Seeders;

use App\Models\DailyPassword;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DailyPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addYear();
        $dateRange = CarbonPeriod::create($startDate, $endDate);

        foreach ($dateRange as $date) {
            DailyPassword::factory()
                ->state([
                    'date' => Carbon::parse($date)->toDateString(),
                ])
                ->create();
        }

        Cache::forget('dsp');
    }
}
