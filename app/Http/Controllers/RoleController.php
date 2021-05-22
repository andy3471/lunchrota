<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UpdateRolesRequest;
use App\Http\Requests\Admin\ImportCsvRolesRequest;
use App\Jobs\Admin\UpdateRolesJob;
use App\Jobs\Admin\ImportCsvRolesJob;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            ->where('users.app_del', '=', false)
            ->orderBy('users.name')
            ->get();

        return $roles;
    }
}
