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
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Auth\WardController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\DoctorProfileController;
use App\Http\Controllers\Admin\NurseController;
use App\Http\Controllers\Admin\Auth\NurseProfileController;
use App\Http\Controllers\Auth\PatientProfileController;
use App\Http\Controllers\Auth\PatientAppointmentController;
use App\Http\Controllers\Admin\AdminController;
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

    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);   
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']); 

// Route::group(['middleware' => ['role:doctor']], function () {
    
      Route::group(['middleware' => ['role:doctor','auth:sanctum'], 'prefix' => 'admin/'], function () {
        //..user..//
        Route::get('users', [UserController::class, 'index']);
        Route::post('users', [UserController::class, 'store']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::PUT('users/{user}', [UserController::class, 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);
        Route::get('search-users/{search}', [UserController::class, 'search']);
     });

        //..admin doctor..//

      Route::group(['middleware' => ['role:doctor','auth:sanctum'], 'prefix' => 'admin/'], function () {

        Route::get('doctors', [AdminController::class, 'index']);
        Route::post('doctors', [AdminController::class, 'store']);
        Route::get('doctors/{doctor}', [AdminController::class, 'show']);
        Route::PUT('doctors/{doctor}', [AdminController::class, 'update']);
        Route::delete('doctors/{doctor}', [AdminController::class, 'destroy']);
        Route::get('search-doctors/{search}', [AdminController::class, 'search']);

      });

      Route::group(['middleware' => ['role:doctor','auth:sanctum'], 'prefix' => 'admin/'], function () {
        Route::get('rooms', [RoomController::class, 'index']);
        Route::post('rooms', [RoomController::class, 'store']);
        Route::get('rooms/{room}', [RoomController::class, 'show']);
        Route::PUT('rooms/{room}', [RoomController::class, 'update']);
        Route::delete('rooms/{room}', [RoomController::class, 'destroy']);
        Route::get('search-rooms/{search}', [RoomController::class, 'search']);
      });

      Route::group(['middleware' => ['role:doctor','auth:sanctum'], 'prefix' => 'admin/'], function () {
        Route::post('/doctor-profiles/{doctor}', [DoctorProfileController::class, 'doctorProfile'])->middleware('auth:sanctum');
      });

      Route::group(['middleware' => ['role:doctor|nurse','auth:sanctum'], 'prefix' => 'admin/'], function () {
         Route::get('services', [ServiceController::class, 'index']);
         Route::post('services', [ServiceController::class, 'store']);
         Route::get('services/{service}', [ServiceController::class, 'show']);
         Route::PUT('services/{service}', [ServiceController::class, 'update']);
         Route::delete('services/{service}', [ServiceController::class, 'destroy']);
         Route::get('search-services/{search}', [ServiceController::class, 'search']);
      });

      Route::group(['middleware' => ['role:doctor','auth:sanctum'], 'prefix' => 'admin/'], function () {
        //..appointment..//
        Route::get('appointments', [AppointmentController::class, 'index']);
        Route::get('status/{appoint}', [AppointmentController::class, 'status']);
        Route::get('councel-appointment/{appoint}', [AppointmentController::class, 'removeAppointment']);

      });

          Route::group(['middleware' => ['role:doctor|nurse','auth:sanctum'], 'prefix' => 'admin/'], function () {
            Route::get('nurses', [NurseController::class, 'index']);
            Route::post('nurses', [NurseController::class, 'store']);
            Route::get('nurses/{nurse}', [NurseController::class, 'show']);
            Route::PUT('nurses/{nurse}', [NurseController::class, 'update']);
            Route::delete('nurses/{nurse}', [NurseController::class, 'destroy']);
            Route::get('search-nurses/{search}', [NurseController::class, 'search']);
        });

        Route::group(['middleware' => ['role:doctor|patient','auth:sanctum']], function () {
            Route::get('patients', [PatientController::class, 'index']);
            Route::post('patients', [PatientController::class, 'store']);
            Route::get('patients/{patient}', [PatientController::class, 'show']);
            Route::PUT('patients/{patient}', [PatientController::class, 'update']);
            Route::delete('patients/{patient}', [PatientController::class, 'destroy']);
            Route::get('search-patients/{search}', [PatientController::class, 'search']);
        });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::group(['middleware' => ['role:doctor|nurse','auth:sanctum'], 'prefix' => 'admin/'], function () {
        Route::post('/nurse-profiles/{nurse}', [NurseProfileController::class, 'nurseProfile'])->middleware('auth:sanctum');
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient','auth:sanctum']], function () {
        Route::post('appointments', [PatientAppointmentController::class, 'store'])->middleware('auth:sanctum');
        Route::get('my-appointments', [PatientAppointmentController::class, 'appointment'])->middleware('auth:sanctum');    
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient','auth:sanctum']], function () {
        Route::get('get-doctors', [getAllDoctorController::class, 'allDoctor']);
        Route::get('get-doctors/{$id}', [getAllDoctorController::class, 'getDoctorByService']);
        Route::get('search-services/{search}', [getAllDoctorController::class, 'search']);
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient','auth:sanctum']], function () {
        Route::get('get-nurses', [getAllNurseController::class, 'allNurse']);
        Route::get('get-nurses/{$id}', [getAllNurseController::class, 'getNurse']);
        Route::get('search-nurses/{search}', [getAllNurseController::class, 'search']);
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient','auth:sanctum']], function () {
        Route::get('get-services', [getAllServiceController::class, 'allDoctor']);
        Route::get('get-services/{$id}', [getAllServiceController::class, 'getService']);
        Route::get('search-services/{search}', [getAllServiceController::class, 'search']);
      });

      Route::group(['middleware' => ['role:doctor|nurse','auth:sanctum']], function () {
        Route::get('wards', [WardController::class, 'index']);
        Route::post('wards', [WardController::class, 'store']);
        Route::get('wards/{ward}', [WardController::class, 'show']);
        Route::PUT('wards/{ward}', [WardController::class, 'update']);
        Route::delete('wards/{ward}', [WardController::class, 'destroy']);
      });

      Route::group(['middleware' => ['role:doctor|nurse','auth:sanctum']], function () {
        Route::get('tests', [TestController::class, 'index']);
        Route::get('remove-tests/{test}', [TestController::class, 'removeTest']);
        Route::get('status/{test}', [TestController::class, 'updateTest']);
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient','auth:sanctum']], function () {
        Route::post('/patient-profiles/{patient}', [PatientProfileController::class, 'updateProfile']);
      });

      Route::group(['middleware' => ['role:doctor|nurse|patient','auth:sanctum']], function () {
        Route::post('save-tests', [PatientTestController::class, 'storeTest']);
        Route::get('my-test', [PatientTestController::class, 'getTestId']);
      });

    //...patient...//

