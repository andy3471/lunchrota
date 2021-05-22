<?php

namespace App\Jobs;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangePasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ChangePasswordRequest
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ChangePasswordRequest $request)
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
        $user = Auth::user();
        $user->password = bcrypt($this->request->newpassword);
        $user->save();
    }
}
