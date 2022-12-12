<?php

namespace App\Listeners\Patient;

use App\Mail\AppointmentMail;
use App\Models\Appointment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PatientAppointmentMail
{

    private $appointment;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->appointment)->send(new AppointmentMail($event->appointment));
    }
}
