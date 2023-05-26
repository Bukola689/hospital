<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Doctor;
use Illuminate\Http\Request;

class getAllDoctorController extends Controller
{
    public function allDoctor()
    {
        $allDoctors = cache()->rememberForever('doctor:all', function () {
            return Doctor::orderBy('id', 'desc')->paginate(5);
        });

        return response()->json([
            'success' => true,
            'allDoctors' => $allDoctors
        ]);
    }

    public function getDoctorByService($id)
    {
        //$post = Post::find($id);
       

         $doctorId =Cache()->rememberForever('doctor:'. $id, function () use ($id) {
            return Doctor::with('service')->where('id', $id)->get();;
        });

        // return new PostResource($post);
        return response()->json([
            'status' => true,
            'doctor' => $doctorId
        ]);
    }

    public function searchDoctor($search)
    {
        $doctor = Doctor::with('Service')->where('title', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($doctor) {
            return response()->json([
                'success' => true,
                'doctor' => $doctor
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'doctor not found'
            ]);
        }
    }

}
