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
        $users = User::withTrashed()->orderBy('name')->get();
        return view('admin.users.index')->withUsers($users);
    }

    public function adminUsersGet()
    {
        $users = User::withTrashed()->orderBy('name')->get();
        return $users;
    }

    public function adminUsersPost(Request $request)
    {
        $this->validate($request, [
            'users.*.name'      => 'required|string',
            'users.*.email'     => 'email',
            'users.*.admin'     => 'required|boolean',
            'users.*.deleted'   => 'required|boolean',
            'users.*.new_password' => 'nullable|string|min:6',
        ]);

        $users = collect($request->users);

        foreach ($users as $u) {
            $user = User::withTrashed()->where('id', $u['id'])->first();

            if ($u['deleted'] and !$user->deleted) {
                $user->delete();
            } elseif (!$u['deleted'] and $user->deleted) {
                $user->restore();
            }
            if (!$u['new_password'] == '') {
                $user->password =  bcrypt($u['new_password']);
            }

            $user->name = $u['name'];
            $user->email = $u['email'];
            $user->admin = $u['admin'];
            $user->save();
        }

        return User::withTrashed()->get();
    }
}
