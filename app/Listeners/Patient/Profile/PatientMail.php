<?php

namespace App\Listeners\Patient\Profile;

use App\Mail\Patient\Profile\PatientsMail;
use App\Models\Patient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PatientMail
{

    private $patient;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->patient)->send(new PatientsMail($event->patient));
    }
}
