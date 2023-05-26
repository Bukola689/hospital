<?php

use App\Http\Controllers\Nurse\AppointmentController;
use Illuminate\Support\Facades\Route;


Route::get('appointments', [AppointmentController::class, 'index']);
Route::post('status/{appoint}', [AppointmentController::class, 'status']);
Route::get('councel-appointment/{appoint}', [AppointmentController::class, 'removeAppointment']);
