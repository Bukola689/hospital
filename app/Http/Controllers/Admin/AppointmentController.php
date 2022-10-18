<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();

        return $appointments;
    }

    public function status(Request $request, Appointment $appoint)
    {
        if($appoint) {
            $appoint->status = $request->appointment['status'] ? 'Approved' : 'pending';
            $appoint->save();

            return response()->json([
                'appointment' => $appoint
            ]);
        }
       
    }

    public function removeAppointment(Appointment $appoint)
    {
        $appoint = $appoint->delete();

        return response()->json([
            'message' => 'Appointment removed Successfully',
            'appoint' => $appoint
        ]);
    }
}
