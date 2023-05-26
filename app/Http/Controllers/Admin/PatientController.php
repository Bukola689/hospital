<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Events\Patient\Profile\Patient as ProfilePatient;
use App\Events\Patient\Profile\Patients;
use App\Models\Patient;
use App\Http\Resources\PatientResource;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Repository\Admin\Patient\PatientRepository;
use Illuminate\Support\Facades\Cache;

class PatientController extends Controller
{
    public $patient;

    public function __construct(PatientRepository $patient)
    {
        $this->patient = $patient;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Cache::remember('patients', now()->addDay(), function () {
            return Patient::orderBy('id', 'desc')->paginate(5);
        });

        if($patients->isEmpty()) {
            return response()->json('Patient Not Found');
        }

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
        
      $data = $request->all();

      $this->patient->savePatient($request, $data);

      Cache::put('patient', $data);

        return response()->json([
            'message' => 'Patient Saved Suucessfully'
        ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);

        if(! $patient) {
            return response()->json('patient Not Found');
        }

        $patientShow = Cache::remember('patient:'. $patient->id, now()->addDay(), function () use ($patient) {
            return $patient;
        });
        return new PatientResource($patientShow);
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
    public function update(UpdatePatientRequest $request,  $id)
    {
        $patient = Patient::find($id);

        if(! $patient) {
            return response()->json('patient Not Found');
        }

        $data = $request->all();

        $this->patient->updatePatient($request, $patient, $data);

        Cache::put('patient', $data);

      return response()->json([
        'status' => 'Patient Updated Successfully'
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if(! $patient) {
            return response()->json('patient Not Found');
        }

       $this->patient->removePatient($patient);

       Cache::pull('patient');

        return response()->json([
            'status' => 'Patient Removed Successfully'
        ]);
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
