<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ViewDoctorProfileController extends Controller
{
    public function viewSingleDoctor(Doctor $doctor)
    {
        {
            return response()->json($doctor);
        }
    }
}
