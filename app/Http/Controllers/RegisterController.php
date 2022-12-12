<?php

namespace App\Http\Controllers;

use App\Events\Register\UserRegister;
use App\Models\User;
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

        event(new Registered($user));

        event(new UserRegister($user));

        $token  = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        return response($response, 201);
    }
}
