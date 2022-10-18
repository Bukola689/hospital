<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Http\Resources\DoctorResource;
use Illuminate\Http\Request;

class doctorProfileController extends Controller
{
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'user_id' => 'required',
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

      $doctor = $request->user();

      $doctor->user_id = $request->input('user_id');
      $doctor->first_name = $request->input('first_name');
      $doctor->last_name = $request->input('last_name');
      $doctor->d_o_b = $request->input('d_o_b');
      $doctor->phone = $request->input('phone');
      $doctor->room_id = $request->input('room_id');
      $doctor->service_id = $request->input('service_id');
      $doctor->address = $request->input('address');
      $doctor->update();

      return new DoctorResource($doctor);
    }

}
