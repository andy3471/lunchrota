<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUsersUpdateRequest;
use App\Jobs\AdminUsersUpdateJob;
use Illuminate\Http\Request;
use App\Rules\CurrentPassword;
use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
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

    /**
     * @return mixed
     */
    public function adminUsers()
    {
        $users = User::withTrashed()->orderBy('name')->get();
        return view('admin.users.index')->withUsers($users);
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function adminUsersGet()
    {
        $users = User::withTrashed()->orderBy('name')->get();
        return $users;
    }

    /**
     * @param Request $request
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function adminUsersPost(AdminUsersUpdateRequest $request)
    {
        AdminUsersUpdateJob::dispatchNow($request);
        return User::withTrashed()->orderBy('name')->get();
    }
}
