<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Jobs\Admin\StoreUserJob;
use App\Jobs\Admin\UpdateUsersJob;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        StoreUserJob::dispatchNow($request);

        return redirect()->back()->with('message', 'User Created');
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
     * @param  Request  $request
     * @return User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function adminUsersPost(UpdateUsersRequest $request)
    {
        UpdateUsersJob::dispatchNow($request);

        return User::withTrashed()->orderBy('name')->get();
    }
}
