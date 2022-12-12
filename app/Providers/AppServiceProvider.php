<?php

namespace App\Providers;

use App\Repository\Admin\Doctor\DoctorRepository;
use App\Repository\Admin\Doctor\IDoctorRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind(DoctorRepository ::class, IDoctorRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
