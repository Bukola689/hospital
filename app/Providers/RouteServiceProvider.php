<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::prefix('admin')
                ->middleware(['auth:sanctum', 'role:admin'])
                ->namespace($this->namespace)
                ->name('admin.')
                ->group(base_path('routes/api/v1/admin/users.php'));
            
            Route::prefix('admin')
                ->middleware(['auth:sanctum', 'role:admin'])
                ->namespace($this->namespace)
                ->name('admin.')
                ->group(base_path('routes/api/v1/admin/nurses.php'));

            Route::prefix('admin')
                ->middleware(['auth:sanctum', 'role:admin'])
                ->namespace($this->namespace)
                ->name('admin.')
                ->group(base_path('routes/api/v1/admin/patients.php'));

            Route::prefix('admin')
                ->middleware(['auth:sanctum', 'role:admin'])
                ->namespace($this->namespace)
                ->name('admin.')
                ->group(base_path('routes/api/v1/admin/tests.php'));

            Route::prefix('admin')
                ->middleware(['auth:sanctum', 'role:admin'])
                ->namespace($this->namespace)
                ->name('admin.')
                ->group(base_path('routes/api/v1/admin/services.php'));

            Route::prefix('nurse')
                ->middleware(['auth:sanctum', 'role:admin|nurse'])
                ->namespace($this->namespace)
                ->name('nurse.')
                ->group(base_path('routes/api/v1/nurse/rooms.php'));


            Route::prefix('nurse')
                ->middleware(['auth:sanctum', 'role:admin|nurse'])
                ->namespace($this->namespace)
                ->name('nurse.')
                ->group(base_path('routes/api/v1/nurse/appointments.php'));

            Route::prefix('nurse')
                ->middleware(['auth:sanctum', 'role:admin|nurse'])
                ->namespace($this->namespace)
                ->name('nurse.')
                ->group(base_path('routes/api/v1/nurse/tests.php'));

            Route::prefix('nurse')
                ->middleware(['auth:sanctum', 'role:admin|nurse'])
                ->namespace($this->namespace)
                ->name('nurse.')
                ->group(base_path('routes/api/v1/nurse/nurse-profile.php'));

            Route::prefix('patient')
                ->middleware(['auth:sanctum', 'role:admin|patient'])
                ->namespace($this->namespace)
                ->name('patient.')
                ->group(base_path('routes/api/v1/patient/patient-appointment.php'));

            Route::prefix('patient')
                ->middleware(['auth:sanctum', 'role:admin|patient'])
                ->namespace($this->namespace)
                ->name('patient.')
                ->group(base_path('routes/api/v1/patient/patientProfile.php'));
                
            // Route::prefix(['v1','admin/'])
            //      ->middleware(['auth:sanctum', 'role:doctor'])
            //      ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
