<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Http\Resources\PatientResource;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::orderBy('id', 'desc')->get();

        return PatientResource::Collection($patients);
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
     * @param  \App\Http\Requests\StorePatientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatientRequest $request)
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

        return new PatientResource($patient); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        return new PatientResource($patient);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientRequest  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
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

      return new PatientResource($patient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient = $patient->delete();

        return new PatientResource($patient);
    }

    public function search($search)
    {
        $patients = Patient::where('first_name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($patients) {
            return response()->json([
                'success' => true,
                'patients' => $patients
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'patients not found'
            ]);
        }
    }
}
