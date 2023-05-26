<?php

namespace App\Subscriber\Model\Auth;

use App\Events\User\Auth\UserLogout;
use App\Listeners\User\LoggedMail;
use Illuminate\Events\Dispatcher;

class ProfileSubscriber
{
    public function LoginSubscriber(Dispatcher $events)
    {
        $events->listen(UserLogout::class, LoggedMail::class);
    }
}