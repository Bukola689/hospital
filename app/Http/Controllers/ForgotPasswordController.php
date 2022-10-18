<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordReset;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|string'
        ]);
        
        if (! $user = User::firstWhere(['email' => $request->email])) {
            return "Email does not exist.";
        }


        if ($user->is_locked) {
            return response()->json(['This action cannot be performed while your account is locked.']);
        }

        $reset = PasswordReset::createToken($request->email);

        Mail::to($request->email)->send((new PasswordResetMail($user, $reset)));

        return "Reset password link has been sent to your email.";

    }
}
