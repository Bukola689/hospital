<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Events\Patient\ChangePassword;
use App\Events\Patient\UpdateUserProfile;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
       $request->validate([
        "old_password" => "required",
        "password" => "required",
        "confirm_password" => "required|same:password"
       ]);

        $user = $request->user();
       
        if( Hash::check($request->old_password, $user->password)){
            
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            event(new ChangePassword($user));

           return response()->json([
              'message'=> 'Password Updated Successfully',
           ], 200);

        } else {
            return response()->json([
                'message' => 'check your password and try again  !'
            ]);
        }

        
    }
}
