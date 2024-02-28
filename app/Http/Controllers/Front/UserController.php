<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Jobs\ChangePasswordJob;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function changePassword(ChangePasswordRequest $request): RedirectResponse
    {
        ChangePasswordJob::dispatchSync($request);

        return redirect()->back()->with('message', 'Password Changed');
    }
}
