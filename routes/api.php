<?php

use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Auth\ResetPasswordController;
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

  
    Route::group(['v1'], function() {

      
      Route::get('/doctors', [AdminController::class, 'index']);
      Route::get('/doctors/{id}', [AdminController::class, 'show']);
      Route::get('/nurses', [NurseController::class, 'index']);
      Route::get('/nurses/{id}', [NurseController::class, 'show']);
      Route::get('/patients', [PatientController::class, 'index']);
      Route::get('/patients/{id}', [PatientController::class, 'show']);
      
      
      //...auth...//

    Route::group(['prefix'=> 'auth'], function() {
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
        Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
      Route::group(['middleware' => 'api:auth'], function() {
        Route::post('logout', [LogoutController::class, 'logout']);
        Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');
        Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 

       });
     });

     Route::group(['middleware' => 'me', 'middleware' => 'auth:sanctum'], function() {

      Route::post('/profiles', [ProfileController::class, 'updateProfile']);
      Route::post('/change-password', [ProfileController::class, 'changePassword']);

      Route::get('/doctor-profiles/{id}', [DoctorProfileController::class, 'doctorProfile']);

     });

    

     Route::group(['middleware' => ['role:super-admin'], 'prefix' => 'admin'], function () {

       Route::get('/users', [UserController::class, 'index']);
       Route::post('/users', [UserController::class, 'store']);
       Route::get('/users/{id}', [UserController::class, 'show']);
       Route::put('/users/{id}', [UserController::class, 'update']);
       Route::DELETE('/users/{id}', [UserController::class, 'destroy']);
       Route::post('users/{id}/suspend', [UserController::class, 'suspend']);
       Route::post('users/{id}/active', [UserController::class, 'active']);
       Route::get('users/{id}/roles', [AdminRoleController::class, 'show']);
       Route::get('users/{id}/permissions', [AdminPermissionController::class, 'show']);
       Route::post('users/{id}/roles', [AdminRoleController::class, 'changeRole']);
       Route::get('search-users/{search}', [UserController::class, 'searchUser']);
      
      
     });

     Route::group(['middleware' => ['role:doctoradmin'], 'prefix' => 'doctor'], function () {

      Route::post('/doctors', [AdminController::class, 'store']);
      Route::put('/doctors/{id}', [AdminController::class, 'update']);
      Route::DELETE('/doctors/{id}', [AdminController::class, 'destroy']);
      Route::post('/nurses', [NurseController::class, 'store']);
      Route::put('/nurses/{nurse}', [NurseController::class, 'update']);
      Route::DELETE('/nurses/{id}', [NurseController::class, 'destroy']);
      Route::post('/patients', [PatientController::class, 'store']);
      Route::put('/patients/{id}', [PatientController::class, 'update']);
      Route::DELETE('/patients/{id}', [PatientController::class, 'destroy']);
      Route::get('/services', [ServiceController::class, 'index']);
      Route::get('/services/{id}', [ServiceController::class, 'show']);
      Route::post('/services', [ServiceController::class, 'store']);
      Route::put('/services/{id}', [ServiceController::class, 'update']);
      Route::DELETE('/services/{id}', [ServiceController::class, 'destroy']);
      Route::get('search-services/{search}', [ServiceController::class, 'search']);
      Route::get('/rooms', [RoomController::class, 'index']);
      Route::post('/rooms', [RoomController::class, 'store']);
      Route::get('/rooms/{id}', [RoomController::class, 'show']);
      Route::put('/rooms/{id}', [RoomController::class, 'update']);
      Route::DELETE('/rooms/{id}', [RoomController::class, 'destroy']);

     });


     Route::group(['middleware' => ['role:nurse'], 'prefix' => 'nurse'], function () {

      Route::get('appointments', [AppointmentController::class, 'index']);
      Route::post('status/{appoint}', [AppointmentController::class, 'status']);
      Route::get('councel-appointment/{appoint}', [AppointmentController::class, 'removeAppointment']);
      Route::get('tests', [TestController::class, 'index']);
      Route::get('remove-tests/{test}', [TestController::class, 'removeTest']);
      Route::get('status/{test}', [TestController::class, 'updateTest']);

      Route::post('/nurse-profiles', [NurseProfileController::class, 'nurseProfile']);
      Route::get('my-profile', [NurseProfileController::class, 'singleNurse']);

     });

     Route::group(['middleware' => ['role:patient'], 'prefix' => 'patient'], function () {

      Route::post('appointments', [PatientAppointmentController::class, 'store']);
      Route::get('my-appointments', [PatientAppointmentController::class, 'appointment']);
      
      Route::post('save-tests', [PatientTestController::class, 'storeTest']);
      Route::get('my-test', [PatientTestController::class, 'getTestId']);

      Route::post('patient-profiles', [patientProfileController::class, 'update']);
      Route::get('view-patient-profile', [ViewPatientProfileController::class, 'singleParent']);

      });

   });


  