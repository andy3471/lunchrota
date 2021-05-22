<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdateLunchSlotsRequest;
use App\Jobs\Admin\UpdateLunchSlotsJob;
use App\LunchSlot;
use Auth;
use App\Http\Controllers\Controller;

class LunchSlotController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.lunches.index');
    }

    /**
     * @return mixed
     */
    public function getAdminSlots()
    {
        return LunchSlot::orderBy('Time')->get();
    }

    /**
     * @param UpdateLunchSlotsRequest $request
     * @return mixed
     */
    public function adminUpdateLunchSlots(UpdateLunchSlotsRequest $request)
    {
        UpdateLunchSlotsJob::dispatchNow($request);
        return LunchSlot::orderBy('time')->get();
    }
}
