<?php

namespace App\Jobs\Admin;

use App\Http\Requests\Admin\UpdateLunchSlotsRequest;
use App\LunchSlot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateLunchSlotsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var UpdateLunchSlotsRequest
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UpdateLunchSlotsRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $slots = collect($this->request->slots);
        $deletedSlots = LunchSlot::whereNotIn('id', $slots->where('id', '!=', null)->pluck('id')->toArray())->get();

        foreach ($deletedSlots as $slot) {
            $slot->users()->detach();
            $slot->delete();
        };

        foreach ($slots as $s) {
            if ($s['id'] == 0) {
                $slot = new LunchSlot;
                $slot->time = $s['time'];
            } else {
                $slot = LunchSlot::find($s['id']);
            }

            if (!config('app.lunch_slot_calculated')) {
                $slot->available = $s['available'];
            }

            $slot->save();
        }
    }
}
