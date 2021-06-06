<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClaimLunchSlotRequest;
use App\Jobs\ClaimLunchSlotJob;
use App\Jobs\UnclaimLunchSlotJob;
use App\Models\LunchSlot;

class LunchSlotController extends Controller
{
    /**
     * @return mixed
     */
    public function getSlots()
    {
        return LunchSlot::orderBy('time')->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function userLunches()
    {
        return LunchSlot::getUserLunchesToday();
    }

    /**
     * @param ClaimLunchSlotRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\Collection
     */
    public function claim(ClaimLunchSlotRequest $request)
    {
        return ClaimLunchSlotJob::dispatchNow($request);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function unclaim()
    {
        return UnclaimLunchSlotJob::dispatchNow();
    }

}
