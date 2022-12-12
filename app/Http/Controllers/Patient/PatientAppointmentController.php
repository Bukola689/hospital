<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use App\Events\Patient\PatientAppointments;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    public function store(Request $request)
    {
       $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'service_id' => 'required',
            'phone' => 'required',
            'message' => 'required',
            'appointment_date' => 'nullable|date'
        ]);

        $appointment = new Appointment;
        $appointment->patient_id = $request->input('patient_id');
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->service_id = $request->input('service_id');
        $appointment->phone = $request->input('phone');
        $appointment->appointment_date = Carbon::now();
        $appointment->message = $request->input('message');
        $appointment->status = 'Pending';
        if(Auth::id())
        {
            $appointment->user_id = Auth::user()->id;
        }
        $appointment->save();

        event(new PatientAppointments($appointment));

        return response()->json([
            'message' => 'Appointment booked Successfully And We Will Contact You Shortly vis Email!',
            'appointment' => $appointment
        ]);
    }

    public function appointment()
    {
        if(Auth::id())
        {
            $user = Auth::user()->id;

            $appoint = Appointment::where('user_id', $user)->get();

            return response()->json([
                'appoint' => $appoint
            ]);
        }
    }
}
