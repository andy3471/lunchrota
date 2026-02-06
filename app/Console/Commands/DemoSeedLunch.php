<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\LunchSlot;
use App\Models\User;
use Illuminate\Console\Command;

class DemoSeedLunch extends Command
{
    protected $signature = 'demo:seedlunch';

    protected $description = 'Seed Lunch for Today';

    // TODO: Refactor
    public function handle(): void
    {
        $date = \Illuminate\Support\Facades\Date::now();

        if ($date->isWeekday()) {
            $dateString = \Illuminate\Support\Facades\Date::parse($date)->toDateString();

            $users = User::all();

            foreach ($users as $user) {
                $allLunchSlots = LunchSlot::all();
                $lunchSlots    = $allLunchSlots->filter(function ($item): bool {
                    return $item->availableToday > 0;
                });

                if ($lunchSlots->isEmpty()) {
                    $this->line('No Lunch Slots Remaining');
                } else {
                    $lunchSlot = $lunchSlots->random();
                    $user->lunches()->attach($lunchSlots->random(), ['date' => $dateString]);
                    $this->line($user->name.' has been given Lunch Slot '.$lunchSlot->time);
                }
            }
        }
    }
}
