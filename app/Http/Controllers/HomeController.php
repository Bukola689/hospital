<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Nurse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $doctors = Cache::remember('doctors', now()->addDay(), function (){

            return Doctor::orderBy('id', 'desc')->get();

        });

        return response()->json($doctors);
    }

    public function getDoctorById($id)
    {
        $getDoctorById = Cache::remember('doctor:'. $id, now()->addDay(), function () use ($id) {
            return Doctor::where('id', $id)->get();
        });

        return response()->json($getDoctorById);
    }

    public function getDoctorByService($id)
    {        
         $doctor = Doctor::with('service')->where('id', $id)->get();

         Cache::put('doctor', $doctor);

        return response()->json([
            'status' => true,
            'doctor' => $doctor
        ]);
    }


    public function allNurse()
    {
        $allNurse = Nurse::orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'allNurse' => $allNurse
        ]);
    }

    public function getNurseById($id)
    {
         $nurse = Nurse::where('id', $id)->get();

        return response()->json([
            'status' => true,
            'nurse' => $nurse
        ]);
    }
}
