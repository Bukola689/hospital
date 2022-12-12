<?php 

namespace App\Repository\Admin\Doctor;

use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class DoctorRepository implements IDoctorRepository
{
    public function allDoctor()
    {
         $doctors = Doctor::orderBy('id', 'desc')->get();
    }

    public function saveDoctor(StoreDoctorRequest $request,array $data)
    {
        
        $image = $request->image;
  
        $originalName = $image->getClientOriginalName();
  
        $image_new_name = 'image-' .time() .  '-' .$originalName;
  
        $image->move('doctors/image', $image_new_name);

        $doctor = new Doctor;
        $doctor->first_name = $request->input('first_name');
        $doctor->last_name = $request->input('last_name');
        $doctor->d_o_b = $request->input('d_o_b');
        $doctor->phone = $request->input('phone');
        $doctor->room_id = $request->input('room_id');
        $doctor->service_id = $request->input('service_id');
        $doctor->image = 'doctors/image/' . $image_new_name;
        $doctor->address = $request->input('address');
        $doctor->user_id = Auth::user()->id;
        $doctor->save();
    }

    public function updateDoctor($request, Doctor $doctor, array $data)
    {
        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('doctors/image', $image_new_name);
  
            $doctor->image = 'doctors/image/' . $image_new_name;
      }

         $doctor->first_name = $request->input('first_name');
         $doctor->last_name = $request->input('last_name');
         $doctor->d_o_b = $request->input('d_o_b');
         $doctor->phone = $request->input('phone');
         $doctor->room_id = $request->input('room_id');
         $doctor->service_id = $request->input('service_id');
         $doctor->address = $request->input('address');
         $doctor->user_id = Auth::user()->id;
         $doctor->update();

    }

    public function removeDoctor(Doctor $doctor)
    {
        $doctor = $doctor->delete();
    }
}

?>