<?php

namespace App\Listeners\Nurse;

use App\Mail\Nurse\NurseProfilesMail;
use App\Models\Nurse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NurseProfile
{
    public $nurse;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Nurse $nurse)
    {
        $this->nurse = $nurse;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->nurse)->send(new NurseProfilesMail($event->nurse));
    }
}
