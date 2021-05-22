<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\CurrentPassword;
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
}
