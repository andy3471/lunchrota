<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Jobs\ChangePasswordJob;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PasswordController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Auth/ChangePassword');
    }

    public function update(ChangePasswordRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $this->authorize('update', $user);

        dispatch_sync(new ChangePasswordJob($request));

        return redirect('/')->with('message', 'Password Changed');
    }
}
