<?php 

namespace App\Repository\Admin\Patient;

use App\Models\Patient;
use App\Events\Patient\Profile\Patients;
use Illuminate\Http\Request;

class PatientRepository implements IPatientRepository
{
    public function savePatient(Request $request,array $data)
    {
        $image = $request->image;
  
        $originalName = $image->getClientOriginalName();
  
        $image_new_name = 'image-' .time() .  '-' .$originalName;
  
        $image->move('patients/image', $image_new_name);

        $patient = new Patient;
        $patient->user_id = $request->input('user_id');
        $patient->first_name = $request->input('first_name');
        $patient->last_name = $request->input('last_name');
        $patient->d_o_b = $request->input('d_o_b');
        $patient->phone = $request->input('phone');
        $patient->image = 'patients/image/' . $image_new_name;
        $patient->address = $request->input('address');
        $patient->save();
    }

       public function updatePatient(Request $request,Patient $patient, array $data)
       {
        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('patients/image', $image_new_name);
  
            $patient->image = 'patients/image/' . $image_new_name;
      }

      $patient->user_id = $request->input('user_id');
      $patient->first_name = $request->input('first_name');
      $patient->last_name = $request->input('last_name');
      $patient->d_o_b = $request->input('d_o_b');
      $patient->phone = $request->input('phone');
      $patient->address = $request->input('address');
      $patient->update();

      event(new Patients($patient));
       }

       public function removePatient(Patient $patient)
       {
          $patient = $patient->delete();
       }
}