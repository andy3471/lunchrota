<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date;
        $date = Carbon::parse($date)->toDateString();

        $roles = DB::table('users')
            ->select('users.name', 'roles.name as role', 'roles.available')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.date', $date)
            ->orderBy('users.name')
            ->get();

        return $roles;
    }

    public function get(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString();
        $roles = User::find($request->user_id)->roles()->wherePivot('date', $date)->get();

        if ($roles->isEmpty()) {
            return 'None';
        } else {
            return $roles[0]->name;
        }
    }

    public function post(Request $request)
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show(Role $role)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
