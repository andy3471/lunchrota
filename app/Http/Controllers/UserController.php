<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\CurrentPassword;
use Hash;
use Auth;

class UserController extends Controller
{
    public function changePassword(Request $request) {

        $this->validate($request, [
            'currentpassword' => ['required', new CurrentPassword],
            'newpassword' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->newpassword);
        $user->save();

        return redirect()->back()->with( "message", __('Password Changed') );
    }
}
