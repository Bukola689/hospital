<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Events\Doctor\DoctorProfile;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Http\Resources\DoctorResource;
use App\Notifications\Admin\DoctorNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class doctorProfileController extends Controller
{
    public function update(Request $request, Doctor $doctor)
    {
       $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'd_o_b' => 'required',
            'phone' => 'required',
            'room_id' => 'required',
            'service_id' => 'required',
            'image' => 'required',
            'address' => 'required',
        ]);

        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('doctors/image', $image_new_name);
  
            $doctor->image = 'doctors/image/' . $image_new_name;
      }

      $doctor = $doctor->user_id = Auth::user()->id;
      $doctor->first_name = $request->input('first_name');
      $doctor->last_name = $request->input('last_name');
      $doctor->d_o_b = $request->input('d_o_b');
      $doctor->phone = $request->input('phone');
      $doctor->room_id = $request->input('room_id');
      $doctor->service_id = $request->input('service_id');
      $doctor->address = $request->input('address');
      $doctor->update();

      $when = Carbon::now()->addSeconds(10);

      event(new DoctorProfile($doctor));

      $doctor->notify((new DoctorNotification($doctor))->delay($when));

      Cache::put('doctor', $data);

      return new DoctorResource($doctor);
    }

    public function viewProfile()
    {
        if(Auth::id())
        {
            $viewSingleDoctor = Doctor::with('user')->where('id', Auth::id())->first();

            return response()->json($viewSingleDoctor);
        }
    }

}
