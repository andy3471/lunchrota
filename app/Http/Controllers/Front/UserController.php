<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Jobs\ChangePasswordJob;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Auth/ChangePassword');
    }

    public function changePassword(ChangePasswordRequest $request): RedirectResponse
    {
        dispatch_sync(new ChangePasswordJob($request));

        return redirect('/')->with('message', 'Password Changed');
    }
}
