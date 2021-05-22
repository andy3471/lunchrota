<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUpdateRolesRequest;
use App\Http\Requests\ImportCsvRolesRequest;
use App\Jobs\AdminUpdateRolesJob;
use App\Jobs\ImportCsvRolesJob;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleAdmin()
    {
        return view('admin.roles.index');
    }

    /**
     * @return mixed
     */
    public function roleAdminGetRoles()
    {
        return Role::orderBy('name')->get();
    }

    public function adminUpdateRoleRequest(AdminUpdateRolesRequest $request)
    {
        AdminUpdateRolesJob::dispatchNow($request);
        return Role::orderBy('name')->get();
    }

    public function userRolesAdmin()
    {
        $users = User::Where('app_del', '=', false)->get();
        $roles = Role::orderBy('name')->get();
        return view('admin.userroles.index')->withUsers($users)->withRoles($roles);
    }

    public function userRolesUpload()
    {
        return view('admin.userroles.upload');
    }

    public function downloadCsv()
    {
        $filename = "commrotaexport.csv";

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=galleries.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $date = Carbon::yesterday();

        if (config('database.default') == 'mysql') {
            $roles = DB::table('users')
                ->select('users.name', DB::raw('DATE_FORMAT(role_user.date,"%d/%m/%Y") as date'), 'roles.name as role')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('date', '>', $date )
                ->orderBy('role_user.date')
                ->get();
        } else {
            $roles = DB::table('users')
                ->select('users.name', DB::raw("FORMAT(role_user.date, 'd', 'en-gb') as date"), 'roles.name as role')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('date', '>', $date )
                ->orderBy('role_user.date')
                ->get();
        }

        $roles = json_decode(json_encode($roles), true);

        if (count($roles) > 0) {
            array_unshift($roles, array_keys($roles[0]));

            $callback = function () use ($roles) {
                $FH = fopen('php://output', 'w');
                foreach ($roles as $row) {
                    fputcsv($FH, $row);
                }
                fclose($FH);
            };
        } else {
            $callback = function () {
                $FH = fopen('php://output', 'w');

                fputcsv($FH, array('name', 'date', 'role'));
                fclose($FH);
            };
        }

        return response()->streamDownload($callback, $filename, $headers);
    }

    public function importCsvRoles(ImportCsvRolesRequest $request)
    {
        $messages = ImportCsvRolesJob::dispatchNow($request);
        return view('admin.userroles.confirmupload')->withMessages($messages->all());
    }
}
