<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // TODO: Refactor this
    public function index(Request $request): JsonResponse
    {
        $date = $request->date;
        $date = \Illuminate\Support\Facades\Date::parse($date)->toDateString();

        $roles = DB::table('users')
            ->select('users.name', 'roles.name as role', 'roles.is_available')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.date', $date)
            ->oldest('users.name')
            ->get();

        return response()->json($roles);
    }
}
