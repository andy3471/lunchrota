<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        return view('admin.users.index');
    }

    public function roles()
    {
        return view('admin.roles.index');
    }

    public function upload()
    {
        return view('admin.roles.upload');
    }
}
