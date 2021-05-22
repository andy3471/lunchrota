<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;
use App\Models\LunchSlot;

class DemoSeedLunch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:seedlunch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Lunch for Today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::now();

        if ($date->isWeekday()) {
            $dateString = Carbon::parse($date)->toDateString();

            $users = User::all();

            foreach ($users as $user) {
                $allLunchSlots = LunchSlot::all();
                $lunchSlots = $allLunchSlots->filter(function ($item){
                    return $item->availableToday > 0;
                });

                if($lunchSlots->isEmpty()) {
                    $this->line('No Lunch Slots Remaining');
                } else {
                    $lunchSlot = $lunchSlots->random();
                    $user->lunches()->attach($lunchSlots->random(), ['date' => $dateString]);
                    $this->line($user->name . ' has been given Lunch Slot ' . $lunchSlot->time);
                }
            };
        }
    }
}
