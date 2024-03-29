<?php

namespace App\Http\Controllers;

use App\Events\Register\UserRegister;
use App\Models\User;
use App\Notifications\RegisterNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
         // event(new UserRegister(User::factory()->make()));

        $user = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required' 
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $token  = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        $when = Carbon::now()->addSeconds(10);

        event(new Registered($user));

        event(new UserRegister($user));

        $user->notify((new RegisterNotification($user))->delay($when));

        cache()->forget('user:all');

        return response($response, 201);
    }
}
