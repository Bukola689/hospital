<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Nurse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('id', 'desc')->get();

        return response()->json($doctors);
    }

    public function getDoctorByService($id)
    {
        
         $doctor = Doctor::with('service')->where('id', $id)->get();

        // return new PostResource($post);
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
