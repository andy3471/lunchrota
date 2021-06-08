<?php

namespace App\Jobs\Admin;

use App\Http\Requests\Admin\SetUserRoleRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetUserRoleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var SetUserRoleRequest
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SetUserRoleRequest $request)
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
        $user = User::find($this->request->user_id);

        $user->roles()->wherePivot('date', $date)->detach();

        if ($this->request->role_id == 0) {
            return 'None';
        } else {
            $user->roles()->attach($this->request->role_id, ['date' => $date]);
            $role = Role::find($this->request->role_id);
            return $role->name;
        }
    }
}
