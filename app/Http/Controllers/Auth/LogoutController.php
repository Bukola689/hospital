<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Events\User\Auth\UserLogout;
use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request, User $user) 
    {
      $user = $user->tokens()->delete();

        event(new UserLogout($user));

        return response()->json('Successfully logged out');
    }
}
