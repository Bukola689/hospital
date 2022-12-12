<?php 

namespace App\Repository\Admin\User;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserRepository implements IUserRepository
{
    public function saveUser(Request $request, array $data)
    {
        $user = new User;
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        $user->save();

    }

    public function updateUser(Request $request,User $user, array $data)
    {
        $user->username = $request->input('username');
        $user->update();
    }

    public function removeUser(User $user)
    {
        $user = $user->delete();

    }
}