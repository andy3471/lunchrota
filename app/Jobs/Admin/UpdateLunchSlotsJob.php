<?php

declare(strict_types=1);

namespace App\Jobs\Admin;

use App\Http\Requests\Admin\UpdateLunchSlotsRequest;
use App\Models\LunchSlot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateLunchSlotsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    // TODO: Move to filament
    // TODO: Never pass the request

    public function __construct(
        public UpdateLunchSlotsRequest $request
    ) {}

    // TODO: Tidy this
    public function handle(): void
    {
        $slots        = collect($this->request->slots);
        $deletedSlots = LunchSlot::whereNotIn('id', $slots->where('id', '!=')->pluck('id')->toArray())->get();

        foreach ($deletedSlots as $slot) {
            $slot->users()->detach();
            $slot->delete();
        }

        foreach ($slots as $s) {
            if ($s['id'] === 0) {
                $slot       = new LunchSlot;
                $slot->time = $s['time'];
            } else {
                $slot = LunchSlot::find($s['id']);
            }

            if (! $slot->team?->lunch_slot_calculated) {
                $slot->available = $s['available'];
            }

            $slot->save();
        }
    }
}
