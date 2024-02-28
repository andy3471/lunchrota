<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportCsvRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use App\Jobs\Admin\ImportCsvRolesJob;
use App\Jobs\Admin\UpdateRolesJob;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // TODO: Move to filament

    /**
     * @return string
     */
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

    /**
     * @return string
     */
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

    /**
     * @return mixed
     */
    public function adminUpdateRoleRequest(UpdateRolesRequest $request)
    {
        UpdateRolesJob::dispatchNow($request);

        return Role::orderBy('name')->get();
    }

    /**
     * @return mixed
     */
    public function userRolesAdmin()
    {
        $users = User::Where('app_del', '=', false)->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.userroles.index')->withUsers($users)->withRoles($roles);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userRolesUpload()
    {
        return view('admin.userroles.upload');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadCsv()
    {
        $filename = 'commrotaexport.csv';

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=galleries.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        $date = Carbon::yesterday();

        if (config('database.default') == 'mysql') {
            $roles = DB::table('users')
                ->select('users.name', DB::raw('DATE_FORMAT(role_user.date,"%d/%m/%Y") as date'), 'roles.name as role')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('date', '>', $date)
                ->orderBy('role_user.date')
                ->get();
        } else {
            $roles = DB::table('users')
                ->select('users.name', DB::raw("FORMAT(role_user.date, 'd', 'en-gb') as date"), 'roles.name as role')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('date', '>', $date)
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

                fputcsv($FH, ['name', 'date', 'role']);
                fclose($FH);
            };
        }

        return response()->streamDownload($callback, $filename, $headers);
    }

    /**
     * @return mixed
     */
    public function importCsvRoles(ImportCsvRolesRequest $request)
    {
        $messages = ImportCsvRolesJob::dispatchNow($request);

        return view('admin.userroles.confirmupload')->withMessages($messages->all());
    }
}
