<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Nurse;
use App\Http\Resources\NurseResource;
use Illuminate\Http\Request;

class nurseProfileController extends Controller
{
    public function update(Request $request, Nurse $nurse)
    {
        $request->validate([
            'user_id' => 'required',
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

      $nurse->user_id = $request->input('user_id');
      $nurse->first_name = $request->input('first_name');
      $nurse->last_name = $request->input('last_name');
      $nurse->d_o_b = $request->input('d_o_b');
      $nurse->phone = $request->input('phone');
      $nurse->room_id = $request->input('room_id');
      $nurse->service_id = $request->input('service_id');
      $nurse->address = $request->input('address');
      $nurse->update();

      return new NurseResource($nurse);
    }
}
