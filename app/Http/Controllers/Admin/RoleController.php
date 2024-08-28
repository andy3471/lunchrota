<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportCsvRolesRequest;
use App\Jobs\Admin\ImportCsvRolesJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function upload()
    {
        return view('admin.user-roles.upload');
    }

    public function download()
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

    public function import(ImportCsvRolesRequest $request)
    {
        $messages = ImportCsvRolesJob::dispatchNow($request);

        return view('admin.user-roles.confirm-upload')->withMessages($messages->all());
    }
}
