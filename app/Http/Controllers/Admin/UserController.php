<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repository\Admin\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{

    public $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Cache::remember('users', now()->addDay(), function () {
            return User::orderBy('id', 'desc')->paginate(5);
        });

        if($users->isEmpty()) {
            return response()->json('User not found');
        }

        return response()->json([
            'status' => true,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    { 
        $data = $request->all();

       $this->user->saveUser($request, $data);

       Cache::put('user', $data);

       return response()->json([
        'status' => true,
        'message' => 'User Added Successfully !'
       ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json('User Id Not Found');
        }

        $userShow = Cache::remember('user:'. $user->id, now()->addDay(), function () use ($user) {
            return $user;
        });


        return response()->json($userShow);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

       $data = $request->all();

       if (!$user) {
        return response()->json('User Id Not Found');
       }

       $this->user->updateUser($request,$user, $data);

       Cache::put('user', $data);

       return response()->json([
        'message' => 'User Updated Successfully'
       ]);
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json('User Id Not Found');
           }
        
        $this->user->removeUser($user);

       Cache::pull('user');
        
        return response()->json([
            'messagfe' => 'User removed Successsfully'
        ]);
    }

    public function suspend($id)
    {
       $user = User::find($id);

       if(! $user) {
           throw new NotFoundHttpException('user not found');
        }

        $user->active = false;
        $user->save();

        return response()->json([
           'message' => 'User Suspended Successfully'
        ]);
    }

    public function active($id)
    {

       $user = User::find($id);

       if(! $user) {
           throw new NotFoundHttpException('user not found');
        }

        $user->active = true;
        $user->save();

        return response()->json([
           'message' => 'User Been Active Successfully'
        ]);
    }
}
