<?php

declare(strict_types=1);

namespace App\Jobs\Admin;

use App\Http\Requests\Admin\UpdateRolesRequest;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateRolesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    // TODO: Move to filament
    // TODO: Never pass the request

    public function __construct(
        public UpdateRolesRequest $request
    ) {}

    // TODO: Tidy this
    public function handle(): void
    {
        $roles        = collect($this->request->roles);
        $deletedRoles = Role::whereNotIn('id', $roles->where('id', '!=')->pluck('id')->toArray())->get();

        foreach ($deletedRoles as $role) {
            $role->users()->detach();
            $role->delete();
        }

        foreach ($roles as $r) {
            if ($r['id'] === 0) {
                $role       = new Role;
                $role->name = $r['name'];
            } else {
                $role = Role::find($r['id']);
            }

            $role->available = $r['available'];
            $role->save();
        }
    }
}
