<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class UserLunchSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        $date = Date::now();

        if (! $date->isWeekday()) {
            return;
        }

        $dateString = $date->toDateString();

        Team::all()->each(function (Team $team) use ($dateString): void {
            $lunchSlots = $team->lunchSlots;

            foreach ($team->members as $user) {
                $availableSlots = $lunchSlots->filter(fn ($item): bool => $item->getAvailableForDate($dateString) > 0);

                if ($availableSlots->isEmpty()) {
                    break;
                }

                $lunchSlot = $availableSlots->random();
                $user->lunches()->attach($lunchSlot, ['date' => $dateString]);
            }
        });
    }
}
