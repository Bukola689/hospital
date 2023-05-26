<?php

namespace App\Http\Controllers;

use App\Events\User\UserLoggin;
use App\Models\User;
use App\Notifications\LoginNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

      $user = User::where('email', $data['email'])->first();

      if(!$user || !Hash::check($data['password'], $user->password))
      {
          return response(['message'=>'invalid credentials'], 401);
      } else {
        $token  = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        $when = Carbon::now()->addSeconds(10);

        event(new UserLoggin($user));

        $user->notify((new LoginNotification($user))->delay($when));

        Cache::put('user');

        return response($response, 200);
      }
    }
}
