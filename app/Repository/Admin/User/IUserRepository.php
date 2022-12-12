<?php 

namespace App\Repository\Admin\User;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

interface IUserRepository
{
    public function saveUser(Request $request,array $data);

    public function updateUser(Request $request,User $user, array $data);

    public function removeUser(User $user);
}