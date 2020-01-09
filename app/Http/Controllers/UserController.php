<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\CurrentPassword;
use App\User;
use Auth;

class UserController extends Controller
{
    public function changePassword(Request $request)
    {

        $this->validate($request, [
            'currentpassword' => ['required', new CurrentPassword],
            'newpassword' => 'required|string|min:6|confirmed|different:currentpassword',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->newpassword);
        $user->save();

        return redirect()->back()->with("message", 'Password Changed');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with("message", 'User Created');
    }

    public function adminUsers()
    {
        $users = User::withTrashed()->get();
        return view('admin.users.index')->withUsers($users);
    }

    public function adminUsersGet()
    {
        $users = User::orderBy('name')->get();
        return $users;
    }
}
