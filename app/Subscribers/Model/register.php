<?php

namespace App\Subscriber\Model;

use App\Events\Register\UserRegister;
use App\Listeners\Register\RegisterMail;
use Illuminate\Events\Dispatcher;

class RegisterSubscriber
{
    public function RegisterSubscriber(Dispatcher $events)
    {
        $events->listen(UserRegister::class, RegisterMail::class);
    }
}