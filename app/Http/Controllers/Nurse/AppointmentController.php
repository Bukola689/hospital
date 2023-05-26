<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Cache::remember('appointment', now()->addDay(), function () {
             return Appointment::orderBy('id', 'desc')->get();
        });

        if($appointments->isEmpty()) {
            return response()->json('Appointment is Empty');
        }

        return response()->json($appointments);
    }

    public function status(Request $request, $id)
    {
        $appoint = Appointment::find($id);
        if($appoint) {
            $appoint->status = $request->appointment['status'] ? 'Approved' : 'pending';
            $appoint->save();

            Cache::put('doctor');

            return response()->json([
                'appointment' => $appoint
            ]);
        }
       
    }

    public function removeAppointment(Appointment $appoint)
    {
         $appoint->delete();

         Cache::pull('doctor');

        return response()->json([
            'message' => 'Appointment removed Successfully',
            'appoint' => $appoint
        ]);
    }
}
