<?php

namespace App\Subscriber\Model\Profile;

use App\Events\Nurse\NurseProfile;
use App\Listeners\Nurse\NurseProfile as NurseNurseProfile;
use Illuminate\Events\Dispatcher;

class ProfileSubscriber
{
    public function profileSubscriber(Dispatcher $events)
    {
        $events->listen(NurseProfile::class, NurseNurseProfile::class);
    }
}