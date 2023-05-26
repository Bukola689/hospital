<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewPatientProfileController extends Controller
{
    public function viewSingleProfile(Patient $patient)
    {

        $patientShow = Cache()->rememberForever('patient:'. $patient->id, now()->addDay(), function () use ($patient) {
            return $patient;
        });

        return response()->json($patientShow);
        
    }
}
