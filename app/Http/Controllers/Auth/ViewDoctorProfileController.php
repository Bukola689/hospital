<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ViewDoctorProfileController extends Controller
{
    public function viewSingleDoctor(Doctor $doctor)
    {

        $doctorShow = Cache()->rememberForever('doctor:'. $doctor->id, now()->addDay(), function () use ($doctor) {
            return $doctor;
        });
        
            return response()->json($doctorShow);
    }
}
