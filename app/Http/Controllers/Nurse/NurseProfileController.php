<?php

namespace App\Http\Controllers\Nurse;

use App\Events\Nurse\NurseProfile;
use App\Http\Controllers\Controller;

use App\Models\Nurse;
use App\Http\Resources\NurseResource;
use App\Notifications\Nurse\NurseNotification;
use Carbon\Carbon;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NurseProfileController extends Controller
{
    public function nurseProfile(Request $request, Nurse $nurse)
    {
       $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'd_o_b' => 'required',
            'phone' => 'required',
            'image' => 'required',
            'address' => 'required',
        ]);

        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('nurses/image', $image_new_name);
  
            $nurse->image = 'nurses/image/' . $image_new_name;
      }

      $nurse->user_id = Auth::user()->id;
      $nurse->first_name = $request->input('first_name');
      $nurse->last_name = $request->input('last_name');
      $nurse->d_o_b = $request->input('d_o_b');
      $nurse->phone = $request->input('phone');
      $nurse->address = $request->input('address');
      $nurse->update();

      $when = Carbon::now()->addSeconds(10);

      event(new NurseProfile($nurse));

      $nurse->notify((new NurseNotification($nurse))->delay($when));

      cache()->forget('nurse', $data);

      return new NurseResource($nurse);
    }

    public function sigleNurse()
    {
        if(Auth::id())
        {
            $viewSingleNurse = Nurse::with('user')->where('id', Auth::id())->first();

            return response()->json($viewSingleNurse);
        }
    }
}
