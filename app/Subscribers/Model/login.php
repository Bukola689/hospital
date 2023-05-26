<?php

namespace App\Subscriber\Model;

use App\Events\User\UserLoggin;
use App\Listeners\User\LoggedMail;
use Illuminate\Events\Dispatcher;

class ProfileSubscriber
{
    public function LoginSubscriber(Dispatcher $events)
    {
        $events->listen(UserLoggin::class, LoggedMail::class);
    }
}