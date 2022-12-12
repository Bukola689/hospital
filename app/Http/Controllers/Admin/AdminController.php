<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Http\Resources\DoctorResource;
use App\Repository\Admin\Doctor\DoctorRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $doctor;

    public function __construct(DoctorRepository $doctor)
    {
        $this->doctor = $doctor;
    }


    public function index()
    {
        $doctors = $this->doctor->allDoctor;

        return DoctorResource::Collection($doctors);
    }

    public function store(StoreDoctorRequest $request)
    {     
        
        $data = $request->all();

        $this->doctor->saveDoctor($request, $data);

        return response()->json([
            'message' => 'Doctor has been Saved Successfully'
        ]); 
    }

    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $data = $request->all();
      
       $this->doctor->updateDoctor($request, $doctor, $data);

       return response()->json([
        'message'  => 'Doctor Updated Successfully'
       ]);
    }

    public function destroy(Doctor $doctor)
    {
        $this->doctor->removeDoctor($doctor);

        return response()->json([
            'status' => 'Doctor Removed Successfully',
            'message' => $doctor,
        ]);
    }

    public function search($search)
    {
        $doctors = Doctor::where('first_name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($doctors) {
            return response()->json([
                'success' => true,
                'doctors' => $doctors
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'doctors not found'
            ]);
        }
    }
}
