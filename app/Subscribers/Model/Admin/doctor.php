<?php

namespace App\Subscriber\Model\Doctor;

use App\Events\Doctor\DoctorProfile;
use App\Listeners\Doctor\DoctorProfileMail;
use Illuminate\Events\Dispatcher;

class DoctorSubscriber
{
    public function DoctorSubscriber(Dispatcher $events)
    {
        $events->listen(DoctorProfile::class, DoctorProfileMail::class);
    }
}