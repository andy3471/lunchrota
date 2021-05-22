<?php

namespace App\Jobs\Admin;

use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class UpdateUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var UpdateUsersRequest
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UpdateUsersRequest $request)
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
        $users = collect($this->request->users);
        Cache::forget('appdelsupport');

        foreach ($users as $u) {
            $user = User::withTrashed()->where('id', $u['id'])->first();

            if ($u['deleted'] and !$user->deleted) {
                $user->delete();
            } elseif (!$u['deleted'] and $user->deleted) {
                $user->restore();
            }
            if (!$u['new_password'] == '') {
                $user->password =  bcrypt($u['new_password']);
            }

            $user->name = $u['name'];
            $user->email = $u['email'];
            $user->admin = $u['admin'];
            $user->app_del = $u['app_del'];
            $user->scheduled = $u['scheduled'];
            $user->save();
        }

    }
}
