<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Jobs\ChangePasswordJob;
use Auth;

class UserController extends Controller
{
    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        ChangePasswordJob::dispatchNow($request);
        return redirect()->back()->with("message", 'Password Changed');
    }
}
