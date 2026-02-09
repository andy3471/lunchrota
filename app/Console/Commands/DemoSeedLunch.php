<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Team;
use Illuminate\Console\Command;

class DemoSeedLunch extends Command
{
    protected $signature = 'demo:seedlunch';

    protected $description = 'Seed Lunch for Today';

    public function handle(): void
    {
        $date = \Illuminate\Support\Facades\Date::now();

        if (! $date->isWeekday()) {
            $this->line('Today is a weekend day, skipping.');

            return;
        }

        $dateString = $date->toDateString();

        Team::all()->each(function (Team $team) use ($dateString): void {
            $this->line("Seeding lunches for team: {$team->name}");

            $lunchSlots = $team->lunchSlots;

            foreach ($team->members as $user) {
                $availableSlots = $lunchSlots->filter(fn ($item): bool => $item->getAvailableForDate($dateString) > 0);

                if ($availableSlots->isEmpty()) {
                    $this->line('No Lunch Slots Remaining');

                    break;
                }

                $lunchSlot = $availableSlots->random();
                $user->lunches()->attach($lunchSlot, ['date' => $dateString]);
                $this->line("{$user->name} has been given Lunch Slot {$lunchSlot->time}");
            }
        });
    }
}
