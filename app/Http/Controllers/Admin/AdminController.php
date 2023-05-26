<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Http\Resources\DoctorResource;
use App\Repository\Admin\Doctor\DoctorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    protected $doctor;

    public function __construct(DoctorRepository $doctor)
    {
        $this->doctor = $doctor;
    }

    public function index()
    {
        $doctors = Cache::rememberForever('doctors', 60, function () {
            return  $this->doctor->allDoctor();
        });

        if($doctors->isEmpty()) {
            return response()->json('Doctors Not Found');
        }

        return DoctorResource::Collection($doctors);
    }

    public function store(StoreDoctorRequest $request)
    {     
        
        $data = $request->all();

        $this->doctor->saveDoctor($request, $data);

        Cache::put('doctor', $data);

        return response()->json([
            'message' => 'Doctor has been Saved Successfully'
        ]); 
    }

    public function show($id)
    {
        $doctor = Doctor::find($id);

        if(! $doctor) {
            return response()->json('Doctor Not Found');
        }

        $doctorShow = Cache::remember('doctor:'. $doctor->id, now()->addDay(), function () use ($doctor) {
            return $doctor;
        });

        return new DoctorResource($doctorShow);
    }

    public function update(UpdateDoctorRequest $request, $id)
    {
        $doctor = Doctor::find($id);

        if(! $doctor) {
            return response()->json('Doctor Not Found');
        }

        $data = $request->all();
      
       $this->doctor->updateDoctor($request, $doctor, $data);

       Cache::put('doctor', $data);

       return response()->json([
        'message'  => 'Doctor Updated Successfully'
       ]);
    }

    public function destroy($id)
    {
        $doctor = Doctor::find($id);

        if(! $doctor) {
            return response()->json('Doctor Not Found');
        }

        $this->doctor->removeDoctor($doctor);

        Cache::pull('doctor');

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
