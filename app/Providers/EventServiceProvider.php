<?php

namespace App\Providers;

use App\Events\Doctor\DoctorProfile;
use App\Events\Patient\Appointment;
use App\Events\Patient\ChangePassword;
use App\Events\Patient\PatientAppointments;
use App\Events\Patient\Profile\Patients;
use App\Events\Patient\UpdateUserProfile;
use App\Events\Register\UserRegister;
use App\Events\User\UserLoggin;
use App\Listeners\Doctor\DoctorProfileMail;
use App\Listeners\Patient\PatientAppointmentMail;
use App\Listeners\Patient\Profile\ChangePasswordMail;
use App\Listeners\Patient\Profile\PatientMail;
use App\Listeners\Patient\Profile\UpdateProfileMail;
use App\Listeners\Register\RegisterMail;
use App\Listeners\User\LoggedMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserRegister::class => [
            RegisterMail::class
        ],

        UserLoggin::class => [
            LoggedMail::class
        ],

        PatientAppointments::class => [
            PatientAppointmentMail::class
        ],

        Patients::class => [
            PatientMail::class
        ],

        UpdateUserProfile::class => [
            UpdateProfileMail::class
        ],

        DoctorProfile::class => [
            DoctorProfileMail::class
        ],

        ChangePassword::class => [
            ChangePasswordMail::class
        ],
    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
