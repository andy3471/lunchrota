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
}
