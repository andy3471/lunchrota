<?php

namespace App\Jobs;

use App\Http\Requests\ClaimLunchSlotRequest;
use App\Models\LunchSlot;
use Auth;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClaimLunchSlotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ClaimLunchSlotRequest
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ClaimLunchSlotRequest $request)
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
        $date = Carbon::today()->toDateString();
        $lunchslot = LunchSlot::find($this->request->id);

        if ((Auth::User()->app_del || ! Auth::User()->available) || $lunchslot->available_today >= 1) {
            Auth::User()->lunches()->detach();
            Auth::User()->lunches()->attach($this->request->id, ['date' => $date]);
            return LunchSlot::getUserLunchesToday();
        } else {
            return response()->json('This lunch slot has been claimed by another user', 403);
        }
    }
}
