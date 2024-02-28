<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString();
        $roles = User::find($request->user_id)->roles()->wherePivot('date', $date)->get();

        if ($roles->isEmpty()) {
            return 'None';
        } else {
            return $roles[0]->name;
        }
    }

    public function update(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString();

        $user = User::find($request->user_id);

        $user->roles()->wherePivot('date', $date)->detach();

        if ($request->role == 0) {
            return 'None';
        } else {
            $user->roles()->attach($request->role, ['date' => $date]);
            $role = Role::find($request->role);

            return $role->name;
        }
    }
}
