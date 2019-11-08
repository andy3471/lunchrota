<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::withTrashed()->get();
        return view('admin.users.index')->withUsers($users);
    }

    public function roles()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.roles.index')->withUsers($users)->withRoles($roles);
    }

    public function upload()
    {
        return view('admin.roles.upload');
    }
}
