<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Jobs\ChangePasswordJob;
use Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword()
    {
        return Inertia::render('Auth/ChangePassword');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        ChangePasswordJob::dispatchNow($request);
        return redirect()->back()->with("message", 'Password Changed');
    }
}
