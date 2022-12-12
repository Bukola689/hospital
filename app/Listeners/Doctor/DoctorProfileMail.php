<?php

namespace App\Listeners\Doctor;

use App\Mail\Doctor\DoctorProfilesMail;
use App\Models\Doctor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class DoctorProfileMail
{
    private $doctor;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->doctor)->send(new DoctorProfilesMail($event->doctor));
    }
}
