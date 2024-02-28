<?php

namespace App\Jobs\Admin;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // TODO: Move to filament
    // TODO: Never pass the request

    public function __construct(
        public StoreUserRequest $request
    ) {
    }

    public function handle(): User
    {
        $user = User::create($this->request->validated());

        return $user;
    }
}
