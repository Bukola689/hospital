<?php

use App\Http\Controllers\Patient\patientProfileController;
use Illuminate\Support\Facades\Route;


Route::post('patient-profiles', [patientProfileController::class, 'update']);
Route::get('view-patient-profile', [ViewPatientProfileController::class, 'singleParent']);
