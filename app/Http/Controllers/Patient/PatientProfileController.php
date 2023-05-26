<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use App\Models\Patient;
use App\Http\Resources\PatientResource;
use App\Notifications\Patient\PatientNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class patientProfileController extends Controller
{
    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
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

      $patient = $patient->user_id = Auth::user()->id;
      $patient->first_name = $request->input('first_name');
      $patient->last_name = $request->input('last_name');
      $patient->d_o_b = $request->input('d_o_b');
      $patient->phone = $request->input('phone');
      $patient->address = $request->input('address');
      $patient->update();

      $when = Carbon::now()->addSeconds(10);

      event(new Patient($patient));

      $patient->notify((new PatientNotification($patient))->delay($when));

      Cache::put('patient', $data);

      return new PatientResource($patient);
    }

    public function viewProfile()
    {
        if(Auth::id())
        {
            $viewPatientProfile = Cache::remember('patient', now()->addDay(), function () {
                return Patient::with('user')->where('id', Auth::id())->first();
            });

            return response()->json($viewPatientProfile);
        }
    }
}
