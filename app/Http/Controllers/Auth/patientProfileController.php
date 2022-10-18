<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Patient;
use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;

class patientProfileController extends Controller
{
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'd_o_b' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'required'
        ]);
        
        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('patients/image', $image_new_name);
  
            $patient->image = 'patients/image/' . $image_new_name;
      }

      $patient = $request->user();

      $patient->user_id = $request->input('user_id');
      $patient->first_name = $request->input('first_name');
      $patient->last_name = $request->input('last_name');
      $patient->d_o_b = $request->input('d_o_b');
      $patient->phone = $request->input('phone');
      $patient->address = $request->input('address');
      $patient->update();

      return new PatientResource($patient);
    }
}
