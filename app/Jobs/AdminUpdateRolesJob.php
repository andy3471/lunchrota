<?php

namespace App\Jobs;

use App\Http\Requests\AdminUpdateRolesRequest;
use App\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AdminUpdateRolesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AdminUpdateRolesRequest
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AdminUpdateRolesRequest $request)
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
        $roles = collect($this->request->roles);
        $deletedRoles = Role::whereNotIn('id', $roles->where('id', '!=', null)->pluck('id')->toArray())->get();

        foreach ($deletedRoles as $role) {
            $role->users()->detach();
            $role->delete();
        };

        foreach ($roles as $r) {
            if ($r['id'] == 0) {
                $role = new Role;
                $role->name = $r['name'];
            } else {
                $role = Role::find($r['id']);
            }

            $role->available = $r['available'];
            $role->save();
        }
    }
}
