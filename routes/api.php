<?php

use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Auth\getAllDoctorController;
use App\Http\Controllers\Auth\getAllNurseController;
use App\Http\Controllers\Auth\getAllServiceController;
use App\Http\Controllers\Nurse\RoomController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Patient\TestController;
use App\Http\Controllers\Admin\DoctorProfileController;
use App\Http\Controllers\Admin\NurseProfileController;
use App\Http\Controllers\Patient\PatientProfileController;
use App\Http\Controllers\Auth\ViewNurseProfileController;
use App\Http\Controllers\Auth\ViewPatientProfileController;
use App\Http\Controllers\Auth\ViewDoctorProfileController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Patient\PatientAppointmentController;
use App\Http\Controllers\Patient\PatientTestController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These 
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::get('/', [HomeController::class, 'index']);

    Route::get('get-doctors', [HomeController::class, 'allDoctor']);
    Route::get('get-doctors/{id}', [HomeController::class, 'getDoctorByService']);
    Route::get('search-services/{search}', [HomeController::class, 'search']);

    Route::get('get-nurses', [HomeController::class, 'allNurse']);
    Route::get('get-nurses/{id}', [HomeController::class, 'getNurse']);
    Route::get('search-nurses/{search}', [HomeController::class, 'search']);


    
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);   
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']); 

    Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');

// Route::group(['middleware' => ['role:doctor']], function () {

  Route::prefix('v1')->group(function() {

    Route::middleware(['auth:sanctum'])->group(function() {

      Route::post('logout', [LoginController::class, 'logout']);
    
      //...Admin...//

      Route::group(['middleware' => ['role:doctor'], 'prefix' => 'admin/'], function () {
        
        require __DIR__ ."/api/v1/admin/users.php";

       require __DIR__ .'/api/v1/admin/doctors.php';

       require __DIR__ .'/api/v1/admin/services.php';

       require __DIR__ .'/api/v1/patient/patients.php';

        Route::get('appointments', [AppointmentController::class, 'index']);
        Route::post('status/{appoint}', [AppointmentController::class, 'status']);
        Route::get('councel-appointment/{appoint}', [AppointmentController::class, 'removeAppointment']);

     });

           //...nurse..//

      Route::group(['middleware' => ['role:doctor|nurse'], 'prefix' => 'admin/'], function () {
          require __DIR__ .'/api/v1/nurse/nurses.php';
      });


    Route::group(['middleware' => ['role:doctor|nurse']], function () {
      Route::get('tests', [TestController::class, 'index']);
      Route::get('remove-tests/{test}', [TestController::class, 'removeTest']);
      Route::get('status/{test}', [TestController::class, 'updateTest']);
    });

    //..Doctor Profile..??

      Route::group(['middleware' => ['role:doctor'], 'prefix' => 'admin/'], function () {
        Route::get('/doctor-profiles/{doctor}', [DoctorProfileController::class, 'doctorProfile']);
      });

        //...patient..//

        Route::group(['middleware' => ['role:doctor|patient']], function () {
           
        });

 //..NURSE..//

         //..room..///

      Route::group(['middleware' => ['role:doctor|nurse'], 'prefix' => 'admin/'], function () {
         require __DIR__ .'/api/v1/nurse/rooms.php';
       });

        //...nurse profile..//

      Route::group(['middleware' => ['role:doctor|nurse|patient']], function () {
        Route::post('/nurse-profiles', [NurseProfileController::class, 'nurseProfile']);
        Route::get('my-profile', [NurseProfileController::class, 'singleNurse']);
      });

 //..PATIENT

          //...patient...//

     Route::group(['middleware' => ['role:doctor|nurse|patient']], function () {
      Route::post('patient-profiles', [PatientProfileController::class, 'update']);
      Route::get('view-patient-profile', [ViewPatientProfileController::class, 'singleParent']);
     });

      //..Patient Appointment..//

      Route::group(['middleware' => ['role:doctor|nurse|patient']], function () {
        Route::post('appointments', [PatientAppointmentController::class, 'store']);
        Route::get('my-appointments', [PatientAppointmentController::class, 'appointment']);    
      });

          //... Patient Test..//

     Route::group(['middleware' => ['role:doctor|nurse|patient']], function () {
         Route::post('save-tests', [PatientTestController::class, 'storeTest']);
         Route::get('my-test', [PatientTestController::class, 'getTestId']);
      });
    
      //..Auth..//

      Route::group(['middleware' => ['role:doctor|nurse|patient']], function () {
        Route::get('get-doctors', [getAllDoctorController::class, 'allDoctor']);
        Route::get('get-doctors/{id}', [getAllDoctorController::class, 'getDoctorByService']);
        Route::get('search-services/{search}', [getAllDoctorController::class, 'search']);
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient']], function () {
        Route::get('get-nurses', [getAllNurseController::class, 'allNurse']);
        Route::get('get-nurses/{id}', [getAllNurseController::class, 'getNurse']);
        Route::get('search-nurses/{search}', [getAllNurseController::class, 'search']);
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient']], function () {
        Route::get('get-services', [getAllServiceController::class, 'allService']);
        Route::get('get-services/{id}', [getAllServiceController::class, 'getService']);
        Route::get('search-services/{search}', [getAllServiceController::class, 'search']);
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient']], function () {
        Route::get('view-patient-profile/{patient}', [ViewPatientProfileController::class, 'viewSingleProfile']);
        Route::get('single-nurse-profile/{nurse}', [ViewNurseProfileController::class, 'viewSingleDoctor']);
        Route::get('view-doctor-profile/{doctor}', [ViewDoctorProfileController::class, 'viewSingleProfile']);
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient']], function () {
        Route::post('/change-password', [ChangePasswordController::class, 'changePassword']);
      });
  

    });

   });