<?php

namespace App\Subscriber\Model\Admin;

use App\Events\Profile\ProfileCreated;
use App\Listeners\Profile\ProfileListener;
use Illuminate\Events\Dispatcher;

class UserSubscriber
{
    public function UserSubscriber(Dispatcher $events)
    {
        $events->listen(ProfileCreated::class, ProfileListener::class);
    }
}