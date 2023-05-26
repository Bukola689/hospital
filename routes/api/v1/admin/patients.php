<?php

use App\Http\Controllers\Admin\PatientController;

use Illuminate\Support\Facades\Route;


   Route::get('/patients', [PatientController::class, 'index']);
   Route::get('/patients/{patient}', [PatientController::class, 'show']);
   Route::post('/patients', [PatientController::class, 'store']);
   Route::put('/patients/{patient}', [PatientController::class, 'update']);
   Route::DELETE('/patients/{patient}', [PatientController::class, 'destroy']);
   Route::get('search-patients/{search}', [PatientController::class, 'search']);
