<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangePasswordJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    // TODO: NEVER pass the request object to the job constructor

    public function __construct(
        public ChangePasswordRequest $request
    ) {}

    public function handle(): void
    {
        $user           = auth()->user();
        $user->password = bcrypt($this->request->newpassword);
        $user->save();
    }
}
