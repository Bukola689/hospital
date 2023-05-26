<?php

use App\Http\Controllers\Patient\PatientAppointmentController;
use Illuminate\Support\Facades\Route;


Route::post('appointments', [PatientAppointmentController::class, 'store']);
Route::get('my-appointments', [PatientAppointmentController::class, 'appointment']);   