<?php

namespace App\Jobs\Admin;

use App\Http\Requests\Admin\StoreAppDelSupportDayRequest;
use App\Models\AppDelSupportDay;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class StoreAppDelSupportDayJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var StoreAppDelSupportDayRequest
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(StoreAppDelSupportDayRequest $request)
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
        $date = Carbon::parse($this->request->date)->toDateString();
        $user_id = $this->request->user_id;
        $on_support = $this->request->on_support;

        if ($on_support) {
            $supportDay = new AppDelSupportDay;
            $supportDay->user_id = $user_id;
            $supportDay->date = $date;
            $supportDay->Save();
            Cache::forget('appdelsupport');
            return true;
        } else {;
            $supportDay = AppDelSupportDay::where('user_id', '=', $user_id)->where('date', '=', $date);
            $supportDay->delete();
            Cache::forget('appdelsupport');
            return false;
        }
    }
}
