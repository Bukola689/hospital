<?php

namespace App\Http\Controllers\Auth;

use App\Events\Patient\ChangePassword;
use App\Http\Controllers\Controller;

use App\Events\Patient\UpdateUserProfile;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function updateProfile(Request $request,User $profile)
    {
        $request->validate([
            'username' => 'required',
            //'email' => 'required',
        ]);

       

    }

}
